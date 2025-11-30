<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Symptom;
use App\Services\DiagnosisEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * AssessmentController
 * 
 * Handles the health assessment wizard flow:
 * 1. Display symptom selection
 * 2. Collect severity ratings
 * 3. Capture vital signs
 * 4. Record medical history
 * 5. Store assessment and trigger diagnosis
 */
class AssessmentController extends Controller
{
    protected $diagnosisEngine;

    public function __construct(DiagnosisEngine $diagnosisEngine)
    {
        $this->middleware('auth');
        $this->diagnosisEngine = $diagnosisEngine;
    }

    /**
     * Display the assessment creation form
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get all symptoms grouped by category
        $symptoms = Symptom::select('id', 'name', 'category', 'description')
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category');

        return view('assessment.index', compact('symptoms'));
    }

    /**
     * Store a new assessment
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'symptoms' => 'required|array|min:1',
            'symptoms.*' => 'exists:symptoms,id',
            'severity' => 'required|array',
            'severity.*' => 'in:mild,moderate,severe',
            'duration' => 'required|array',
            'duration.*' => 'integer|min:0|max:365',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'bp_systolic' => 'nullable|integer|min:70|max:250',
            'bp_diastolic' => 'nullable|integer|min:40|max:150',
            'temperature' => 'nullable|numeric|min:35|max:42',
            'oxygen_saturation' => 'nullable|integer|min:70|max:100',
            'chronic_conditions' => 'nullable|array',
            'current_medications' => 'nullable|string|max:1000',
            'allergies' => 'nullable|string|max:1000',
            'smoking_status' => 'nullable|in:no,yes,former',
            'exercise_frequency' => 'nullable|in:daily,3-5,1-2,rarely,never',
            'additional_info' => 'nullable|string|max:2000',
        ]);

        DB::beginTransaction();
        
        try {
            // Create the assessment
            $assessment = Assessment::create([
                'user_id' => Auth::id(),
                'heart_rate' => $validated['heart_rate'] ?? null,
                'blood_pressure_systolic' => $validated['bp_systolic'] ?? null,
                'blood_pressure_diastolic' => $validated['bp_diastolic'] ?? null,
                'temperature' => $validated['temperature'] ?? null,
                'oxygen_saturation' => $validated['oxygen_saturation'] ?? null,
                'chronic_conditions' => json_encode($validated['chronic_conditions'] ?? []),
                'current_medications' => $validated['current_medications'] ?? null,
                'allergies' => $validated['allergies'] ?? null,
                'smoking_status' => $validated['smoking_status'] ?? null,
                'exercise_frequency' => $validated['exercise_frequency'] ?? null,
                'notes' => $validated['additional_info'] ?? null,
                'assessment_date' => now(),
            ]);

            // Attach symptoms with severity and duration
            foreach ($validated['symptoms'] as $symptomId) {
                $assessment->symptoms()->attach($symptomId, [
                    'severity' => $validated['severity'][$symptomId] ?? 'moderate',
                    'duration_days' => $validated['duration'][$symptomId] ?? 1,
                ]);
            }

            // Trigger diagnosis analysis
            $diagnosisResults = $this->diagnosisEngine->analyze($assessment);

            // Store diagnosis results
            foreach ($diagnosisResults as $result) {
                $assessment->diagnosisResults()->create([
                    'condition_id' => $result['condition_id'],
                    'confidence_score' => $result['confidence_score'],
                    'risk_level' => $result['risk_level'],
                    'urgency' => $result['urgency'],
                ]);
            }

            DB::commit();

            // Redirect to diagnosis results
            return redirect()
                ->route('diagnosis.show', $assessment->id)
                ->with('success', 'Assessment completed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log the error
            \Log::error('Assessment creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'An error occurred while processing your assessment. Please try again.');
        }
    }

    /**
     * Display a specific assessment
     * 
     * @param Assessment $assessment
     * @return \Illuminate\View\View
     */
    public function show(Assessment $assessment)
    {
        // Ensure user can only view their own assessments
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to assessment.');
        }

        // Load relationships
        $assessment->load(['symptoms', 'diagnosisResults.condition']);

        return view('assessment.show', compact('assessment'));
    }

    /**
     * Get symptoms by category (AJAX endpoint)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSymptomsByCategory(Request $request)
    {
        $category = $request->input('category', 'all');

        $query = Symptom::select('id', 'name', 'category', 'description');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $symptoms = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'symptoms' => $symptoms
        ]);
    }

    /**
     * Search symptoms (AJAX endpoint)
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchSymptoms(Request $request)
    {
        $search = $request->input('q', '');

        $symptoms = Symptom::where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->select('id', 'name', 'category', 'description')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'symptoms' => $symptoms
        ]);
    }

    /**
     * Delete an assessment
     * 
     * @param Assessment $assessment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Assessment $assessment)
    {
        // Ensure user can only delete their own assessments
        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $assessment->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Assessment deleted successfully.');
    }
}
