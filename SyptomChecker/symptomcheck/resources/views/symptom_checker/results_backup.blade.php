@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1rem;">
    <div class="results-container">
    <h1 style="margin-bottom: 1rem;">Assessment Results</h1>
    <p style="color: var(--gray-600); margin-bottom: 2rem;">Based on your symptoms and vital signs</p>
            @php
                $vitals = $consultation->healthVital;
            @endphp
            
            <div class="card shadow-sm mb-4 border-warning">
                <div class="card-header bg-light border-warning">
                    <h5 class="mb-0">Your Health Vitals</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if ($vitals->blood_pressure_systolic && $vitals->blood_pressure_diastolic)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Blood Pressure:</strong></p>
                                        <p class="h5 mb-0">{{ $vitals->blood_pressure_systolic }}/{{ $vitals->blood_pressure_diastolic }} mmHg</p>
                                    </div>
                                    @if ($vitals->isBloodPressureHigh())
                                        <span class="badge bg-danger">HIGH</span>
                                    @elseif ($vitals->isBloodPressureElevated())
                                        <span class="badge bg-warning text-dark">ELEVATED</span>
                                    @else
                                        <span class="badge bg-success">NORMAL</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($vitals->heart_rate)
                            <div class="col-md-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Heart Rate:</strong></p>
                                        <p class="h5 mb-0">{{ $vitals->heart_rate }} BPM</p>
                                    </div>
                                    @if ($vitals->isHeartRateAbnormal())
                                        <span class="badge bg-warning text-dark">ABNORMAL</span>
                                    @else
                                        <span class="badge bg-success">NORMAL</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($vitals->temperature)
                            <div class="col-md-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Temperature:</strong></p>
                                        <p class="h5 mb-0">{{ $vitals->temperature }}°C</p>
                                    </div>
                                    @if ($vitals->hasElevatedTemperature())
                                        <span class="badge bg-danger">FEVER</span>
                                    @else
                                        <span class="badge bg-success">NORMAL</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- High BP Warning -->
                    @if ($vitals->isBloodPressureHigh())
                        <div class="alert alert-danger mt-3 mb-0">
                            <strong>⚠️ High Blood Pressure Detected</strong>
                            <p class="mb-0 mt-2 small">Your blood pressure reading is elevated. Please consider:</p>
                            <ul class="mb-0 small mt-2">
                                <li>Reducing sodium (salt) intake in your diet</li>
                                <li>Regular physical activity (at least 150 minutes per week)</li>
                                <li>Managing stress through relaxation techniques</li>
                                <li>Limiting alcohol consumption</li>
                                <li>Maintaining a healthy weight</li>
                                <li>Consulting a healthcare professional if readings remain high</li>
                            </ul>
                        </div>
                    @elseif ($vitals->isBloodPressureElevated())
                        <div class="alert alert-warning mt-3 mb-0">
                            <strong>ℹ️ Elevated Blood Pressure</strong>
                            <p class="mb-0 mt-2 small">Your blood pressure is slightly elevated. Monitor it regularly and maintain a healthy lifestyle.</p>
                        </div>
                    @endif

                    <!-- Fever Warning -->
                    @if ($vitals->hasElevatedTemperature())
                        <div class="alert alert-warning mt-3 mb-0">
                            <strong>⚠️ Fever Detected</strong>
                            <p class="mb-0 mt-2 small">You have a fever. Rest, stay hydrated, and monitor your temperature. Seek medical help if it persists or worsens.</p>
                        </div>
                    @endif

                    <!-- Abnormal HR Warning -->
                    @if ($vitals->isHeartRateAbnormal())
                        <div class="alert alert-info mt-3 mb-0">
                            <strong>ℹ️ Abnormal Heart Rate</strong>
                            <p class="mb-0 mt-2 small">Your heart rate is outside the normal range. If you experience dizziness, chest pain, or shortness of breath, seek medical attention.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-0">
                <h1 class="h4 mb-0">Possible conditions</h1>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Selected symptoms:</strong></p>
                <ul>
                    @foreach ($selectedSymptoms as $symptom)
                        <li>{{ $symptom->name }}</li>
                    @endforeach
                </ul>

                @if ($conditions->isEmpty())
                    <div class="alert alert-warning">
                        We couldn't find any matching conditions for the selected symptoms in this demo database.
                        Please review your selection or contact a healthcare professional.
                    </div>
                @else
                    <p class="text-muted small">
                        The list below shows conditions that are commonly associated with the symptoms you selected.
                        They are ordered by how closely they match your symptoms in this demo dataset.
                    </p>

                    <div class="list-group">
                        @foreach ($conditions as $row)
                            @php
                                /** @var \App\Models\Condition $condition */
                                $condition = $row['condition'];
                            @endphp
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="h5 mb-1">{{ $condition->name }}</h2>
                                    <span class="badge
                                        @if ($condition->urgency_level === 'emergency') bg-danger
                                        @elseif ($condition->urgency_level === 'urgent') bg-warning text-dark
                                        @else bg-success
                                        @endif
                                    text-uppercase small">
                                        {{ ucfirst($condition->urgency_level) }}
                                    </span>
                                </div>
                                <p class="mb-2">{{ $condition->description }}</p>

                                <p class="mb-2 small text-muted">
                                    Match score: {{ $row['score'] }} |
                                    Matching symptoms: {{ $row['matchCount'] }} / {{ $row['totalSymptoms'] }}
                                </p>

                                @if ($condition->advice)
                                    <p class="mb-3"><strong>Self‑care / next steps:</strong> {{ $condition->advice }}</p>
                                @endif

                                <!-- Treatments Section -->
                                @if ($condition->treatments->count() > 0)
                                    <div class="mt-3 pt-3 border-top">
                                        <h6 class="mb-3"><strong>Recommended Treatments:</strong></h6>
                                        
                                        @php
                                            $treatmentsByCategory = $condition->treatments->groupBy('category');
                                        @endphp

                                        @foreach ($treatmentsByCategory as $category => $treatments)
                                            <div class="mb-3">
                                                <h6 class="mb-2">
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
                                                </h6>

                                                @foreach ($treatments as $treatment)
                                                    <div class="card card-sm mb-2">
                                                        <div class="card-body p-2">
                                                            <h6 class="card-title mb-1">{{ $treatment->name }}</h6>
                                                            <p class="card-text mb-2 small">{{ $treatment->description }}</p>
                                                            
                                                            @if ($treatment->instructions)
                                                                <details class="mt-2">
                                                                    <summary class="small text-primary cursor-pointer">View detailed instructions</summary>
                                                                    <div class="mt-2 ms-3 p-2 bg-light rounded small">
                                                                        {!! nl2br(e($treatment->instructions)) !!}
                                                                    </div>
                                                                </details>
                                                            @endif

                                                            @if ($treatment->duration || $treatment->frequency)
                                                                <p class="mb-0 mt-2 small text-muted">
                                                                    @if ($treatment->duration)
                                                                        <strong>Duration:</strong> {{ $treatment->duration }}
                                                                    @endif
                                                                    @if ($treatment->frequency)
                                                                        <strong>Frequency:</strong> {{ $treatment->frequency }}
                                                                    @endif
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="alert alert-info mt-4 small mb-0">
                    <strong>Important:</strong> This tool is for education and demonstration only. It does not replace
                    a consultation with a doctor or other qualified healthcare professional. If your symptoms are severe,
                    getting worse, or you are worried about your health, seek urgent medical help.
                </div>

                <a href="{{ route('symptom.index') }}" class="btn btn-link mt-3">Start again</a>
            </div>
        </div>
    </div>
</div>
@endsection
