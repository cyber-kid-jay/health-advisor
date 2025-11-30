@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1rem;">
    <h1 style="margin-bottom: 0.5rem;">Assessment Results</h1>
    <p style="color: var(--gray-600); margin-bottom: 2rem;">Based on your symptoms and vital signs</p>

    @php
        $maxUrgency = 'routine';
        foreach ($conditions as $row) {
            $condition = $row['condition'];
            if ($condition->urgency_level === 'emergency') {
                $maxUrgency = 'emergency';
                break;
            } elseif ($condition->urgency_level === 'urgent' && $maxUrgency !== 'emergency') {
                $maxUrgency = 'urgent';
            }
        }
    @endphp

    <div class="urgency-banner urgency-{{ $maxUrgency }}" style="color: var(--white); padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; font-weight: bold; text-align: center; font-size: 1.1rem;">
        <div style="margin-bottom: 0.5rem;">
            @switch($maxUrgency)
                @case('emergency')
                    🚨 EMERGENCY CARE RECOMMENDED
                @break
                @case('urgent')
                    ⚠️ URGENT CARE RECOMMENDED
                @break
                @default
                    ✅ ROUTINE CARE RECOMMENDED
            @endswitch
        </div>
        <div style="font-size: 0.95rem; opacity: 0.9;">
            @switch($maxUrgency)
                @case('emergency')
                    Seek immediate medical attention or call emergency services
                @break
                @case('urgent')
                    Schedule an urgent appointment with a healthcare provider
                @break
                @default
                    Your symptoms suggest conditions that can typically be managed with self-care
            @endswitch
        </div>
    </div>

    <div style="background: #fee2e2; border-left: 4px solid var(--danger-color); padding: 1rem; margin-bottom: 2rem; border-radius: 0.5rem;">
        <h3 style="color: var(--danger-color); margin-bottom: 0.5rem; margin-top: 0;">⚠️ IMPORTANT REMINDER</h3>
        <p style="margin: 0;">These results are for informational purposes only and should NOT replace professional medical advice. If symptoms worsen or you feel concerned, please contact your healthcare provider or call emergency services.</p>
    </div>

    @if ($consultation->healthVital)
        @php $vitals = $consultation->healthVital; @endphp
        
        <div style="background: var(--white); padding: 2rem; border-radius: 1rem; box-shadow: var(--shadow); margin-bottom: 2rem;">
            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">Your Health Vitals</h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                @if ($vitals->blood_pressure_systolic && $vitals->blood_pressure_diastolic)
                    <div>
                        <p style="margin-bottom: 0.5rem;"><strong>Blood Pressure</strong></p>
                        <p style="font-size: 1.3rem; font-weight: bold; margin: 0.5rem 0;">{{ $vitals->blood_pressure_systolic }}/{{ $vitals->blood_pressure_diastolic }} mmHg</p>
                        @if ($vitals->isBloodPressureHigh())
                            <span style="display: inline-block; background: var(--danger-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">HIGH</span>
                        @elseif ($vitals->isBloodPressureElevated())
                            <span style="display: inline-block; background: var(--warning-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">ELEVATED</span>
                        @else
                            <span style="display: inline-block; background: var(--success-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">NORMAL</span>
                        @endif
                    </div>
                @endif

                @if ($vitals->heart_rate)
                    <div>
                        <p style="margin-bottom: 0.5rem;"><strong>Heart Rate</strong></p>
                        <p style="font-size: 1.3rem; font-weight: bold; margin: 0.5rem 0;">{{ $vitals->heart_rate }} BPM</p>
                        @if ($vitals->isHeartRateAbnormal())
                            <span style="display: inline-block; background: var(--warning-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">ABNORMAL</span>
                        @else
                            <span style="display: inline-block; background: var(--success-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">NORMAL</span>
                        @endif
                    </div>
                @endif

                @if ($vitals->temperature)
                    <div>
                        <p style="margin-bottom: 0.5rem;"><strong>Temperature</strong></p>
                        <p style="font-size: 1.3rem; font-weight: bold; margin: 0.5rem 0;">{{ $vitals->temperature }}°C</p>
                        @if ($vitals->hasElevatedTemperature())
                            <span style="display: inline-block; background: var(--danger-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">FEVER</span>
                        @else
                            <span style="display: inline-block; background: var(--success-color); color: white; padding: 0.25rem 0.75rem; border-radius: 2rem; font-weight: bold; font-size: 0.75rem;">NORMAL</span>
                        @endif
                    </div>
                @endif
            </div>

            <div style="margin-top: 1.5rem; border-top: 1px solid var(--gray-200); padding-top: 1.5rem;">
                @if ($vitals->isBloodPressureHigh())
                    <div style="background: #fee2e2; border-left: 4px solid var(--danger-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
                        <strong style="color: var(--danger-color);">⚠️ High Blood Pressure Detected</strong>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Your reading is elevated. Consider reducing salt intake, regular exercise, stress management, limiting alcohol, and maintaining a healthy weight. Consult a healthcare professional if readings remain high.</p>
                    </div>
                @elseif ($vitals->isBloodPressureElevated())
                    <div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
                        <strong style="color: #92400e;">ℹ️ Elevated Blood Pressure</strong>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Your blood pressure is slightly elevated. Monitor it regularly and maintain a healthy lifestyle.</p>
                    </div>
                @endif

                @if ($vitals->hasElevatedTemperature())
                    <div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
                        <strong style="color: #92400e;">⚠️ Fever Detected</strong>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Rest, stay hydrated, and monitor your temperature. Seek medical help if it persists or worsens.</p>
                    </div>
                @endif

                @if ($vitals->isHeartRateAbnormal())
                    <div style="background: #dbeafe; border-left: 4px solid var(--primary-color); padding: 1rem; border-radius: 0.5rem;">
                        <strong style="color: #1e40af;">ℹ️ Abnormal Heart Rate</strong>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">Your heart rate is outside the normal range. If you experience dizziness, chest pain, or shortness of breath, seek medical attention.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if ($conditions->isEmpty())
        <div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 2rem; border-radius: 0.5rem;">
            <strong style="color: #92400e;">ℹ️ No Matches Found</strong>
            <p style="margin: 0.5rem 0 0 0;">We couldn't find any matching conditions for your symptoms. Please review your selection or contact a healthcare professional.</p>
        </div>
    @else
        <div style="margin-bottom: 2rem;">
            <h2 style="margin-bottom: 1.5rem; color: var(--primary-color);">Possible Conditions</h2>
            
            @foreach ($conditions as $row)
                @php
                    $condition = $row['condition'];
                    $matchPercent = isset($row['confidence']) ? round($row['confidence'] * 100) : round($row['matchRatio'] * 100);
                @endphp
                
                <div style="background: var(--white); padding: 2rem; border-radius: 1rem; box-shadow: var(--shadow); margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                        <h3 style="margin: 0; color: var(--gray-800);">{{ $condition->name }}</h3>
                        @php
                            $matchClass = $matchPercent >= 75 ? 'high' : ($matchPercent >= 50 ? 'moderate' : 'low');
                            $badgeText = $matchPercent >= 75 ? "High Match ($matchPercent%)" : ($matchPercent >= 50 ? "Moderate Match ($matchPercent%)" : "Low Match ($matchPercent%)");
                        @endphp
                        <span class="confidence-badge confidence-{{ $matchClass }}">
                            {{ $badgeText }}
                        </span>
                    </div>

                    @if ($condition->description)
                        <p style="color: var(--gray-600); margin-bottom: 1rem;">{{ $condition->description }}</p>
                    @endif

                    <p style="margin-bottom: 1rem;">
                        <strong>Urgency Level:</strong>
                        <span class="urgency-badge urgency-{{ $condition->urgency_level }}">
                            {{ ucfirst($condition->urgency_level) }}
                        </span>
                    </p>

                    <div style="background: var(--gray-100); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                        <h4 style="margin-top: 0; margin-bottom: 0.5rem;">Matched Symptoms:</h4>
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach ($selectedSymptoms as $symptom)
                                @if($condition->symptoms->contains($symptom->id))
                                    <li>{{ $symptom->name }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    @if ($condition->advice)
                        <div style="background: #dbeafe; border-left: 4px solid var(--primary-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
                            <strong style="color: #1e40af;">💡 Self-Care Recommendations</strong>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.95rem;">{{ $condition->advice }}</p>
                        </div>
                    @endif

                    @if ($condition->treatments->count() > 0)
                        <div style="border-top: 1px solid var(--gray-200); padding-top: 1rem; margin-top: 1rem;">
                            <h4 style="margin-top: 0;">Recommended Treatments:</h4>
                            
                            @php
                                $treatmentsByCategory = $condition->treatments->groupBy('category');
                            @endphp

                            @foreach ($treatmentsByCategory as $category => $treatments)
                                <div style="margin-bottom: 1.5rem;">
                                    <h5 style="margin-bottom: 0.75rem;">
                                        @switch($category)
                                            @case('diet')
                                                🍎 Diet Changes
                                            @break
                                            @case('exercise')
                                                🏃 Exercise & Physical Activity
                                            @break
                                            @case('lifestyle')
                                                🧘 Lifestyle Changes
                                            @break
                                            @case('medication')
                                                💊 Medications
                                            @break
                                            @case('general')
                                                ✓ General Care
                                            @break
                                            @default
                                                📋 Treatments
                                        @endswitch
                                    </h5>

                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                                        @foreach ($treatments as $treatment)
                                            <div style="background: var(--gray-100); padding: 1rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                                                <h6 style="margin-top: 0; margin-bottom: 0.5rem;">{{ $treatment->name }}</h6>
                                                <p style="margin: 0.5rem 0; font-size: 0.9rem; color: var(--gray-700);">{{ $treatment->description }}</p>
                                                
                                                @if ($treatment->instructions)
                                                    <details style="margin-top: 0.5rem;">
                                                        <summary style="cursor: pointer; color: var(--primary-color); font-size: 0.85rem;"><strong>View detailed instructions</strong></summary>
                                                        <div style="margin-top: 0.75rem; padding: 0.75rem; background: var(--white); border-radius: 0.25rem; font-size: 0.85rem;">
                                                            {!! nl2br(e($treatment->instructions)) !!}
                                                        </div>
                                                    </details>
                                                @endif

                                                @if ($treatment->duration || $treatment->frequency)
                                                    <p style="margin: 0.75rem 0 0 0; font-size: 0.85rem; color: var(--gray-600);">
                                                        @if ($treatment->duration)
                                                            <strong>Duration:</strong> {{ $treatment->duration }}<br>
                                                        @endif
                                                        @if ($treatment->frequency)
                                                            <strong>Frequency:</strong> {{ $treatment->frequency }}
                                                        @endif
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div style="background: #fee2e2; border-left: 4px solid var(--danger-color); padding: 1rem; margin-bottom: 2rem; border-radius: 0.5rem;">
        <strong style="color: var(--danger-color);">🚨 When to Seek Medical Care</strong>
        <p style="margin: 0.5rem 0 0 0; font-size: 0.9rem;"><strong>Seek immediate medical attention if you experience:</strong></p>
        <ul style="margin: 0.5rem 0 0 1.5rem; font-size: 0.9rem; padding-left: 1rem;">
            <li>Difficulty breathing or shortness of breath</li>
            <li>Chest pain or pressure</li>
            <li>Severe headache or confusion</li>
            <li>Loss of consciousness or difficulty staying awake</li>
            <li>Severe allergic reaction symptoms</li>
            <li>Thoughts of self-harm</li>
        </ul>
    </div>

    <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem;">
        <h3 style="margin-top: 0;">Your Symptoms</h3>
        <p style="margin-top: 1rem;"><strong>Selected symptoms and their severity:</strong></p>
        
        @php
            $severityData = $consultation->severity_data ?? [];
        @endphp
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 1rem;">
            @foreach ($selectedSymptoms as $symptom)
                @php
                    $symptomSeverity = $severityData[$symptom->id] ?? ['severity' => 'moderate', 'duration' => null];
                    $severity = $symptomSeverity['severity'] ?? 'moderate';
                    $duration = $symptomSeverity['duration'];
                    $severityLabel = ucfirst($severity);
                @endphp
                
                <div class="symptom-card symptom-severity-{{ $severity }}">
                    <h5 style="margin-top: 0; margin-bottom: 0.5rem;">{{ $symptom->name }}</h5>
                    
                    <div style="display: flex; gap: 1rem; font-size: 0.9rem;">
                        <div>
                            <span class="severity-badge severity-{{ $severity }}">
                                {{ $severityLabel }}
                            </span>
                        </div>
                        
                        @if ($duration)
                            <div style="color: var(--gray-700);">
                                <strong>Duration:</strong> {{ $duration }} day{{ $duration != 1 ? 's' : '' }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
        <a href="{{ route('symptom.index') }}" style="padding: 0.75rem 1.5rem; background: var(--primary-color); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s;">Start New Assessment</a>
        <a href="/" style="padding: 0.75rem 1.5rem; background: var(--white); color: var(--primary-color); border: 2px solid var(--primary-color); text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.3s;">Back to Home</a>
    </div>
</div>

<style>
    details summary::-webkit-details-marker {
        display: none;
    }
    
    details summary {
        outline: none;
    }

    .urgency-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-weight: bold;
        font-size: 0.85rem;
        color: white;
    }

    .urgency-badge.urgency-emergency {
        background: var(--danger-color);
    }

    .urgency-badge.urgency-urgent {
        background: var(--warning-color);
    }

    .urgency-badge.urgency-routine {
        background: var(--success-color);
    }

    .confidence-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: bold;
        font-size: 0.85rem;
        color: white;
    }

    .confidence-badge.confidence-high {
        background: #10b981;
    }

    .confidence-badge.confidence-moderate {
        background: #f59e0b;
    }

    .confidence-badge.confidence-low {
        background: #ef4444;
    }

    .urgency-banner {
        color: var(--white);
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
        font-weight: bold;
        text-align: center;
        font-size: 1.1rem;
    }

    .urgency-banner.urgency-emergency {
        background: var(--danger-color);
    }

    .urgency-banner.urgency-urgent {
        background: var(--warning-color);
    }

    .urgency-banner.urgency-routine {

            /* Symptom card styles */
            .symptom-card {
                background: var(--white);
                padding: 1rem;
                border-radius: 0.5rem;
                border-left: 4px solid;
            }

            .symptom-card.symptom-severity-severe {
                border-left-color: #ef4444;
            }

            .symptom-card.symptom-severity-moderate {
                border-left-color: #f59e0b;
            }

            .symptom-card.symptom-severity-mild {
                border-left-color: #10b981;
            }

            /* Severity badge styles */
            .severity-badge {
                display: inline-block;
                color: white;
                padding: 0.25rem 0.75rem;
                border-radius: 0.25rem;
                font-weight: bold;
                font-size: 0.8rem;
            }

            .severity-badge.severity-severe {
                background-color: #ef4444;
            }

            .severity-badge.severity-moderate {
                background-color: #f59e0b;
            }

            .severity-badge.severity-mild {
                background-color: #10b981;
            }
        background: var(--success-color);
    }
</style>
@endsection
