<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use App\Models\Condition;
use App\Models\Consultation;
use App\Models\HealthVital;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class SymptomCheckerController extends Controller
{
    /**
     * Show the symptom checker form.
     */
    public function index()
    {
        $symptoms = Symptom::orderBy('name')->get();

        return view('symptom_checker.index', [
            'symptoms' => $symptoms,
        ]);
    }

    /**
     * Handle the symptom checker submission and show results.
     */
    public function analyze(Request $request)
    {
        $data = $request->validate([
            'symptoms'   => ['required', 'array', 'min:1'],
            'symptoms.*' => ['integer', 'exists:symptoms,id'],
            'symptom_severity' => ['nullable', 'array'],
            'symptom_severity.*' => ['nullable', 'string', 'in:mild,moderate,severe'],
            'symptom_duration' => ['nullable', 'array'],
            'symptom_duration.*' => ['nullable', 'integer', 'min:0', 'max:365'],
            'age'        => ['nullable', 'integer', 'min:0', 'max:120'],
            'gender'     => ['nullable', 'string', 'max:20'],
            'notes'      => ['nullable', 'string', 'max:2000'],
            'bp_systolic' => ['nullable', 'integer', 'min:0', 'max:250'],
            'bp_diastolic' => ['nullable', 'integer', 'min:0', 'max:150'],
            'heart_rate' => ['nullable', 'integer', 'min:0', 'max:220'],
            'temperature' => ['nullable', 'numeric', 'min:30', 'max:45'],
        ]);

        $symptomIds = $data['symptoms'];
        $severityData = $data['symptom_severity'] ?? [];
        $durationData = $data['symptom_duration'] ?? [];

        // Calculate vital abnormality scores
        $vitalAbormalities = 0;
        if (!empty($data['bp_systolic']) && $data['bp_systolic'] >= 140) $vitalAbormalities++;
        if (!empty($data['bp_diastolic']) && $data['bp_diastolic'] >= 90) $vitalAbormalities++;
        if (!empty($data['temperature']) && $data['temperature'] >= 38.0) $vitalAbormalities++;
        if (!empty($data['heart_rate']) && ($data['heart_rate'] < 60 || $data['heart_rate'] > 100)) $vitalAbormalities++;
        $vitalAbnormalityMultiplier = 1 + ($vitalAbormalities * 0.15); // 15% boost per abnormality

        // Fetch relevant conditions and score them based on pivot weight + severity multipliers
        $conditions = Condition::with(['symptoms' => function ($q) use ($symptomIds) {
                $q->whereIn('symptom_id', $symptomIds);
            }, 'treatments'])
            ->whereHas('symptoms', function ($q) use ($symptomIds) {
                $q->whereIn('symptom_id', $symptomIds);
            })
            ->get()
            ->map(function (Condition $condition) use ($symptomIds, $severityData, $vitalAbnormalityMultiplier) {
                // Calculate severity-adjusted score for matched symptoms
                $severityAdjustedScore = 0;
                foreach ($condition->symptoms->whereIn('id', $symptomIds) as $symptom) {
                    $baseWeight = $symptom->pivot->weight ?? 1;
                    $symId = $symptom->id;
                    $severity = $severityData[$symId] ?? 'moderate';
                    $severityMultiplier = $severity === 'severe' ? 2.0 : ($severity === 'moderate' ? 1.5 : 1.0);
                    $severityAdjustedScore += $baseWeight * $severityMultiplier;
                }

                // Compute maximum possible score for this condition (if all symptoms were selected at 'severe')
                $totalPossible = 0;
                foreach ($condition->symptoms as $symptom) {
                    $weight = $symptom->pivot->weight ?? 1;
                    $totalPossible += $weight * 2.0; // 2.0 = severe multiplier
                }

                $matchCount = $condition->symptoms->whereIn('id', $symptomIds)->count();
                $totalForCondition = max($condition->symptoms->count(), 1);
                $matchRatio = $matchCount / $totalForCondition;

                // Normalized severity (0..1)
                $normalizedSeverity = $totalPossible > 0 ? ($severityAdjustedScore / $totalPossible) : 0;

                // Combine normalized severity and match ratio (weighted) then apply vital multiplier
                $combined = ($normalizedSeverity * 0.75) + ($matchRatio * 0.25);
                $confidence = min(1.0, $combined * $vitalAbnormalityMultiplier);

                return [
                    'condition'      => $condition,
                    'rawSeverityScore'=> $severityAdjustedScore,
                    'totalPossible'  => $totalPossible,
                    'normalizedSeverity' => $normalizedSeverity,
                    'confidence'     => $confidence,
                    'matchRatio'     => $matchRatio,
                    'matchCount'     => $matchCount,
                    'totalSymptoms'  => $totalForCondition,
                ];
            })
            ->sortByDesc('confidence')
            ->values();

        // Build severity/duration summary for storage
        $severitySummary = [];
        foreach ($symptomIds as $symId) {
            $severitySummary[$symId] = [
                'severity' => $severityData[$symId] ?? 'moderate',
                'duration' => $durationData[$symId] ?? null,
            ];
        }

        // Persist consultation record with severity data
        $consultation = Consultation::create([
                        'user_id'       => Auth::id(),
            'age'           => $data['age'] ?? null,
            'gender'        => $data['gender'] ?? null,
            'notes'         => $data['notes'] ?? null,
            'symptom_ids'   => $symptomIds,
            'severity_data' => $severitySummary, // Store severity/duration as JSON
            'result_summary'=> $conditions->take(5)->map(function ($row) {
                /** @var \App\Models\Condition $condition */
                $condition = $row['condition'];

                return [
                    'condition'  => $condition->name,
                    'urgency'    => $condition->urgency_level,
                    'confidence' => isset($row['confidence']) ? round($row['confidence'] * 100) : null,
                    'matchRatio' => $row['matchRatio'],
                ];
            })->toArray(),
        ]);

        $consultation->symptoms()->sync($symptomIds);

        // Store health vitals if provided
        if (!empty($data['bp_systolic']) || !empty($data['bp_diastolic']) || 
            !empty($data['heart_rate']) || !empty($data['temperature'])) {
            
            HealthVital::create([
                'consultation_id' => $consultation->id,
                'blood_pressure_systolic' => $data['bp_systolic'] ?? null,
                'blood_pressure_diastolic' => $data['bp_diastolic'] ?? null,
                'heart_rate' => $data['heart_rate'] ?? null,
                'temperature' => $data['temperature'] ?? null,
            ]);
        }

        return view('symptom_checker.results', [
            'conditions'   => $conditions,
            'selectedSymptoms' => Symptom::whereIn('id', $symptomIds)->orderBy('name')->get(),
            'consultation' => $consultation,
        ]);
    }
}
