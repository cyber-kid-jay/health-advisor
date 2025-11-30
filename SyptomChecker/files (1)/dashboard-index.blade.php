@extends('layouts.app')

@section('title', 'Dashboard - HealthAdvisor')

@section('content')
<div class="container">
    <h1>Welcome back, {{ Auth::user()->first_name ?? Auth::user()->name }}!</h1>
    <p class="text-muted mb-4">Here's your health overview</p>

    <!-- Medical Disclaimer -->
    <div class="disclaimer">
        <strong>Remember:</strong> This system provides general information only. Always consult with a healthcare professional for medical advice.
    </div>

    <!-- Dashboard Cards Grid -->
    <div class="dashboard-grid">
        <!-- Quick Assessment Card -->
        <div class="dashboard-card">
            <h3>Quick Assessment</h3>
            <p>Start a new health assessment based on your current symptoms</p>
            <a href="{{ route('assessment.create') }}" class="btn btn-primary btn-block mt-3">
                Start Assessment
            </a>
        </div>

        <!-- Recent Assessments Card -->
        <div class="dashboard-card">
            <h3>Recent Assessments</h3>
            <div class="stat-number">{{ $recentAssessmentsCount }}</div>
            <p>Completed this month</p>
        </div>

        <!-- Active Treatments Card -->
        <div class="dashboard-card">
            <h3>Active Treatments</h3>
            <div class="stat-number">{{ $activeTreatmentsCount }}</div>
            <p>Currently tracking</p>
        </div>

        <!-- Last Assessment Card -->
        @if($lastAssessment)
        <div class="dashboard-card">
            <h3>Last Assessment</h3>
            <p><strong>Condition:</strong> {{ $lastAssessment->primaryDiagnosis->condition->name ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $lastAssessment->assessment_date->format('M d, Y') }}</p>
            <p>
                <strong>Status:</strong> 
                <span class="text-{{ $lastAssessment->getRiskLevel() === 'high' ? 'danger' : 'success' }}">
                    {{ ucfirst($lastAssessment->getRiskLevel()) }} Risk
                </span>
            </p>
        </div>
        @else
        <div class="dashboard-card">
            <h3>Last Assessment</h3>
            <p class="text-muted">No assessments yet</p>
            <a href="{{ route('assessment.create') }}" class="btn btn-primary mt-2">
                Create Your First Assessment
            </a>
        </div>
        @endif
    </div>

    <!-- Assessment History Table -->
    <div class="treatment-section">
        <h3>Assessment History</h3>
        
        @if($assessments->count() > 0)
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
                @foreach($assessments as $assessment)
                <tr>
                    <td>{{ $assessment->assessment_date->format('M d, Y') }}</td>
                    <td>{{ $assessment->primaryDiagnosis->condition->name ?? 'Pending Analysis' }}</td>
                    <td>
                        <span class="text-{{ $assessment->getUrgencyLevel() === 'emergency' ? 'danger' : ($assessment->getUrgencyLevel() === 'urgent' ? 'warning' : 'success') }}">
                            {{ ucfirst($assessment->getUrgencyLevel()) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('diagnosis.show', $assessment->id) }}" class="btn btn-secondary btn-small">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $assessments->links() }}
        </div>
        @else
        <div class="alert alert-info">
            <p>You haven't completed any assessments yet.</p>
            <a href="{{ route('assessment.create') }}" class="btn btn-primary mt-2">
                Start Your First Assessment
            </a>
        </div>
        @endif
    </div>

    <!-- Health Statistics (Optional) -->
    @if($assessments->count() >= 3)
    <div class="treatment-section">
        <h3>Your Health Trends</h3>
        <div class="dashboard-grid">
            <div class="vital-card">
                <h4>Average Heart Rate</h4>
                <div class="stat-number" style="font-size: 2rem;">
                    {{ number_format($avgHeartRate, 0) }} <span style="font-size: 1rem;">bpm</span>
                </div>
            </div>
            <div class="vital-card">
                <h4>Average Blood Pressure</h4>
                <div class="stat-number" style="font-size: 2rem;">
                    {{ number_format($avgBpSystolic, 0) }}/{{ number_format($avgBpDiastolic, 0) }}
                </div>
            </div>
            <div class="vital-card">
                <h4>Most Common Symptom</h4>
                <p style="font-size: 1.25rem; font-weight: bold; margin-top: 1rem;">
                    {{ $mostCommonSymptom ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh page every 5 minutes to show updated data
    setTimeout(() => {
        location.reload();
    }, 300000);
</script>
@endpush
