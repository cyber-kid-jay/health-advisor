@extends('layouts.app')

@section('title', 'Assessment Results')

@section('content')
<div class="container results-container" style="max-width: 900px; margin: 2rem auto; padding: 2rem;">
    <h1 style="margin-bottom: 0.5rem;">Assessment Results</h1>
    <p style="color: var(--gray-600); margin-bottom: 2rem;">{{ $consultation->created_at->format('l, M d, Y \@ H:i') }}</p>

    @php
        $firstUrgency = null;
        if(!empty($consultation->result_summary) && is_array($consultation->result_summary)) {
            $firstUrgency = $consultation->result_summary[0]['urgency'] ?? null;
        }
    @endphp

    <!-- Urgency Banner -->
    @if($firstUrgency)
        <div class="urgency-banner {{ $firstUrgency === 'emergency' ? 'urgency-emergency' : ($firstUrgency === 'urgent' ? 'urgency-urgent' : 'urgency-routine') }}" style="margin-bottom: 2rem; font-weight: bold; padding: 1.5rem; border-radius: 0.5rem; text-align: center; box-shadow: var(--shadow-lg);">
            @if($firstUrgency === 'emergency')
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🚨 EMERGENCY CARE REQUIRED</div>
                <div>Your symptoms suggest an urgent medical condition requiring immediate attention</div>
            @elseif($firstUrgency === 'urgent')
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">⚠️ URGENT ATTENTION NEEDED</div>
                <div>Your symptoms suggest conditions that may require urgent medical evaluation</div>
            @else
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">✅ ROUTINE CARE RECOMMENDED</div>
                <div>Your symptoms suggest conditions that can typically be managed with self-care</div>
            @endif
        </div>
    @endif

    <!-- Important Reminder Disclaimer -->
    <div class="disclaimer disclaimer-critical" style="margin-bottom: 2rem;">
        <h3>⚠️ IMPORTANT REMINDER</h3>
        <p>These results are for informational purposes only and should NOT replace professional medical advice. If symptoms worsen or you feel concerned, please contact your healthcare provider or call emergency services.</p>
    </div>

    <!-- Condition Matches -->
    <div style="margin-bottom: 2rem;">
        @if(!empty($consultation->result_summary) && is_array($consultation->result_summary))
            @foreach($consultation->result_summary as $idx => $row)
                @php
                    // Use stored confidence (%) when available; fall back to legacy 'score'
                    $score = null;
                    if (isset($row['confidence'])) {
                        $score = (float) $row['confidence'];
                    } elseif (isset($row['score'])) {
                        $score = (float) $row['score'];
                    }
                    $score = $score ?? 0;
                    if($score >= 80) {
                        $confidence = 'confidence-high';
                        $confText = 'High Match';
                    } elseif($score >= 50) {
                        $confidence = 'confidence-medium';
                        $confText = 'Moderate Match';
                    } else {
                        $confidence = 'confidence-low';
                        $confText = 'Low Match';
                    }
                @endphp

                <div class="condition-card" style="background: var(--white); padding: 1.5rem; border-radius: 0.75rem; box-shadow: var(--shadow); margin-bottom: 1.5rem; border-left: 4px solid var(--primary-color);">
                    <div class="condition-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
                        <h2 style="margin-bottom: 0; color: var(--primary-color); font-size: 1.5rem;">{{ $row['condition'] ?? 'Unknown Condition' }}</h2>
                        <span class="confidence-badge {{ $confidence }}" style="padding: 0.5rem 1rem; border-radius: 9999px; font-weight: bold; white-space: nowrap;">{{ $confText }} ({{ round($score) }}%)</span>
                    </div>

                    @if(!empty($row['notes']))
                        <p style="color: var(--gray-600); margin-bottom: 1rem;">{{ $row['notes'] }}</p>
                    @endif

                    <h4 style="margin-bottom: 0.5rem;">Matched Symptoms:</h4>
                    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
                        @foreach($selectedSymptoms as $symptom)
                            <li>{{ $symptom->name }}</li>
                        @endforeach
                    </ul>

                    @if($idx === 0)
                        <h4 style="margin-bottom: 0.5rem;">What to Expect:</h4>
                        <p style="color: var(--gray-600); margin-bottom: 1rem;">Symptoms typically last 7-10 days. You're contagious for the first few days after symptoms start.</p>
                        <a href="{{ route('treatment') }}" class="btn btn-primary">View Treatment Recommendations</a>
                    @endif
                </div>
            @endforeach
        @else
            <div class="alert alert-info">No analysis available for this consultation.</div>
        @endif
    </div>

    <!-- When to Seek Medical Care -->
    <div class="treatment-section" style="background: var(--white); padding: 1.5rem; border-radius: 0.75rem; box-shadow: var(--shadow); margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.25rem;">When to Seek Medical Care</h3>

        <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border-left: 4px solid var(--danger-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
            <strong>Seek immediate medical attention if you experience:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <li>Difficulty breathing or shortness of breath</li>
                <li>Chest pain or pressure</li>
                <li>Fever above 39.4°C (103°F)</li>
                <li>Symptoms lasting more than 10 days without improvement</li>
                <li>Severe headache or stiff neck</li>
                <li>Confusion or difficulty staying awake</li>
            </ul>
        </div>

        <div class="alert alert-warning" style="background: #fef3c7; color: #92400e; border-left: 4px solid var(--warning-color); padding: 1rem; border-radius: 0.5rem;">
            <strong>Contact your doctor if:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <li>Symptoms persist beyond 10 days</li>
                <li>You have a chronic condition (diabetes, heart disease, etc.)</li>
                <li>Symptoms are severe or worsening</li>
                <li>You're pregnant</li>
            </ul>
        </div>
    </div>

    <!-- Actions -->
    <div style="text-align: center; margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Return to Dashboard</a>
        <a href="{{ route('symptom.index') }}" class="btn btn-secondary">Start New Assessment</a>
    </div>
</div>
@endsection
