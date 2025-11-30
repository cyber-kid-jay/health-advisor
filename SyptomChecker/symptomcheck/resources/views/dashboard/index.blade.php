@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard-styles.css') }}">

<div class="container">
    <h1>Welcome back, {{ Auth::user()->first_name ?? Auth::user()->name }}!</h1>
    <p class="text-muted mb-4">Here's your health overview</p>

    <div class="disclaimer">
        <strong>Remember:</strong> This system provides general information only. Always consult with a healthcare professional for medical advice.
    </div>

    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h3>Quick Assessment</h3>
            <p>Start a new health assessment based on your current symptoms</p>
            @auth
                <a href="{{ route('symptom.index') }}" class="btn btn-primary">Start Assessment</a>
            @endauth
        </div>

        <div class="dashboard-card">
            <h3>Recent Assessments</h3>
            <div class="stat-number">{{ $recentAssessmentsCount ?? 0 }}</div>
            <p>Completed this month</p>
        </div>

        <div class="dashboard-card">
            <h3>Active Conditions</h3>
            <div class="stat-number">{{ $activeTreatmentsCount ?? 0 }}</div>
            <p>From recent assessments</p>
        </div>

        @if($lastAssessment)
        <div class="dashboard-card">
            <h3>Last Assessment</h3>
            @php
                $primary = null;
                if ($lastAssessment->result_summary && count($lastAssessment->result_summary) > 0) {
                    $primary = $lastAssessment->result_summary[0];
                }
            @endphp
            <p><strong>Condition:</strong> {{ $primary['condition'] ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $lastAssessment->created_at->format('M d, Y') }}</p>
            @if($primary)
                <p><strong>Status:</strong> <span class="text-{{ $primary['urgency'] === 'emergency' ? 'danger' : ($primary['urgency'] === 'urgent' ? 'warning' : 'success') }}">{{ ucfirst($primary['urgency'] ?? 'routine') }}</span></p>
            @endif
        </div>
        @else
        <div class="dashboard-card">
            <h3>Last Assessment</h3>
            <p class="text-muted">No assessments yet</p>
            @auth
                <a href="{{ route('symptom.index') }}" class="btn btn-primary">Create Your First Assessment</a>
            @endauth
        </div>
        @endif
    </div>

    <div class="treatment-section">
        <h3>Assessment History</h3>

        @if($consultations->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Primary Condition</th>
                    <th>Urgency</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $consultation)
                @php
                    $primary = null;
                    $urgency = 'routine';
                    if ($consultation->result_summary && count($consultation->result_summary) > 0) {
                        $primary = $consultation->result_summary[0];
                        $urgency = $primary['urgency'] ?? 'routine';
                    }
                @endphp
                <tr>
                    <td>{{ $consultation->created_at->format('M d, Y') }}</td>
                    <td>{{ $primary['condition'] ?? 'Pending Analysis' }}</td>
                    <td><span class="text-{{ $urgency === 'emergency' ? 'danger' : ($urgency === 'urgent' ? 'warning' : 'success') }}">{{ ucfirst($urgency) }}</span></td>
                    <td>@auth
                        <a href="{{ route('symptom.index') }}" class="btn btn-secondary">View Details</a>
                    @endauth</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $consultations->links() }}</div>
        @else
        <div class="alert-info">
            <p>You haven't completed any assessments yet.</p>
            @auth
                <a href="{{ route('symptom.index') }}" class="btn btn-primary">Start Your First Assessment</a>
            @endauth
        </div>
        @endif
    </div>

    @if($consultations->count() >= 3)
    <div class="treatment-section">
        <h3>Your Health Trends</h3>
        <div class="dashboard-grid">
            @if($avgHeartRate)
            <div class="dashboard-card">
                <h4>Average Heart Rate</h4>
                <div class="stat-number">{{ number_format($avgHeartRate, 0) }} <span style="font-size:1rem">bpm</span></div>
            </div>
            @endif

            @if($avgBpSystolic)
            <div class="dashboard-card">
                <h4>Average Blood Pressure</h4>
                <div class="stat-number">{{ number_format($avgBpSystolic,0) }}/{{ number_format($avgBpDiastolic,0) }}</div>
            </div>
            @endif

            @if($mostCommonSymptom)
            <div class="dashboard-card">
                <h4>Most Common Symptom</h4>
                <p style="font-size:1.25rem;font-weight:700;margin-top:1rem">{{ $mostCommonSymptom }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection
