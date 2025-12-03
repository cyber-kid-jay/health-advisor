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

        // Calculate vital abnormality count and normalized vital score (0..1)
        $vitalAbormalities = 0;
        if (!empty($data['bp_systolic']) && $data['bp_systolic'] >= 140) $vitalAbormalities++;
        if (!empty($data['bp_diastolic']) && $data['bp_diastolic'] >= 90) $vitalAbormalities++;
        if (!empty($data['temperature']) && $data['temperature'] >= 38.0) $vitalAbormalities++;
        if (!empty($data['heart_rate']) && ($data['heart_rate'] < 60 || $data['heart_rate'] > 100)) $vitalAbormalities++;
        $vitalScore = min(1.0, $vitalAbormalities / 4); // normalized 0..1

        // Fetch relevant conditions (load full symptoms list so coverage is computed correctly)
        $conditions = Condition::with(['symptoms', 'treatments'])
            ->whereHas('symptoms', function ($q) use ($symptomIds) {
                $q->whereIn('symptom_id', $symptomIds);
            })
            ->get()
            ->map(function (Condition $condition) use ($symptomIds, $severityData, $vitalScore) {
                // Collect all symptoms for this condition (weights come from pivot)
                $allSymptoms = $condition->symptoms;

                // Sum total weight for condition (all symptoms)
                $totalWeightAll = 0.0;
                foreach ($allSymptoms as $s) {
                    $totalWeightAll += ($s->pivot->weight ?? 1);
                }
                $totalWeightAll = max($totalWeightAll, 1.0);

                // Matched symptoms (those in the user's selection)
                $matched = $allSymptoms->whereIn('id', $symptomIds);

                // Sum matched weights and compute severity-adjusted score
                $matchedWeightSum = 0.0;
                $severityAdjustedScore = 0.0;
                foreach ($matched as $symptom) {
                    $w = ($symptom->pivot->weight ?? 1);
                    $matchedWeightSum += $w;
                    $symId = $symptom->id;
                    $severity = $severityData[$symId] ?? 'moderate';
                    // Severity multipliers: mild=0.9, moderate=1.0, severe=1.4 (safer, less extreme)
                    $severityMultiplier = $severity === 'severe' ? 1.4 : ($severity === 'moderate' ? 1.0 : 0.9);
                    $severityAdjustedScore += $w * $severityMultiplier;
                }

                // Symptom coverage: fraction of total condition weight matched (0..1)
                $coverage = $matchedWeightSum / $totalWeightAll;

                // Severity ratio: how severe the matched symptoms are relative to max possible for those matched
                $maxSeverityForMatched = $matchedWeightSum * 1.4; // using 1.4 as maximal multiplier above
                $severityRatio = $maxSeverityForMatched > 0 ? ($severityAdjustedScore / $maxSeverityForMatched) : 0.0;

                // Combine factors with conservative weighting: coverage most important
                $confidenceRaw = (0.65 * $coverage) + (0.25 * $severityRatio) + (0.10 * $vitalScore);
                $confidence = max(0.0, min(1.0, $confidenceRaw));

                return [
                    'condition' => $condition,
                    'matchedWeight' => $matchedWeightSum,
                    'totalWeight' => $totalWeightAll,
                    'coverage' => $coverage,
                    'severityAdjustedScore' => $severityAdjustedScore,
                    'severityRatio' => $severityRatio,
                    'vitalScore' => $vitalScore,
                    'confidence' => $confidence,
                    'matchCount' => $matched->count(),
                    'totalSymptoms' => max($allSymptoms->count(), 1),
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
                    'coverage'   => isset($row['coverage']) ? round($row['coverage'] * 100, 1) : null,
                    'severityRatio' => isset($row['severityRatio']) ? round($row['severityRatio'] * 100, 1) : null,
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

    /**
     * Show consultation details.
     */
    public function showConsultation($id)
    {
        $consultation = Consultation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $selectedSymptoms = $consultation->symptoms()->get();

        return view('symptom_checker.consultation_detail', [
            'consultation' => $consultation,
            'selectedSymptoms' => $selectedSymptoms,
        ]);
    }
}