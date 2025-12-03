<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\HealthVital;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the user's health dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Get consultation history for current user (paginated)
        $consultations = Consultation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Count recent assessments (this month)
        $recentAssessmentsCount = Consultation::where('user_id', $user->id)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        // Get last assessment
        $lastAssessment = Consultation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Calculate average vitals from health vitals associated with user's consultations
        $avgHeartRate = HealthVital::whereIn('consultation_id', 
                Consultation::where('user_id', $user->id)->pluck('id')
            )
            ->whereNotNull('heart_rate')
            ->avg('heart_rate');

        $avgBpSystolic = HealthVital::whereIn('consultation_id', 
                Consultation::where('user_id', $user->id)->pluck('id')
            )
            ->whereNotNull('blood_pressure_systolic')
            ->avg('blood_pressure_systolic');

        $avgBpDiastolic = HealthVital::whereIn('consultation_id', 
                Consultation::where('user_id', $user->id)->pluck('id')
            )
            ->whereNotNull('blood_pressure_diastolic')
            ->avg('blood_pressure_diastolic');

        // Get most common symptom for this user
        $mostCommonSymptom = null;
        $userConsultationIds = Consultation::where('user_id', $user->id)->pluck('id');
        
        if ($userConsultationIds->isNotEmpty()) {
            $symptomCounts = DB::table('consultation_symptom')
                ->whereIn('consultation_id', $userConsultationIds)
                ->select('symptom_id', DB::raw('count(*) as count'))
                ->groupBy('symptom_id')
                ->orderByDesc('count')
                ->first();

            if ($symptomCounts) {
                $symptom = \App\Models\Symptom::find($symptomCounts->symptom_id);
                $mostCommonSymptom = $symptom ? $symptom->name : null;
            }
        }

        // Count active treatments (conditions from recent consultations)
        $activeTreatmentsCount = 0;
        if ($lastAssessment && isset($lastAssessment->result_summary)) {
            $activeTreatmentsCount = count($lastAssessment->result_summary);
        }

        return view('dashboard.index', [
            'user' => $user,
            'consultations' => $consultations,
            'recentAssessmentsCount' => $recentAssessmentsCount,
            'lastAssessment' => $lastAssessment,
            'avgHeartRate' => $avgHeartRate,
            'avgBpSystolic' => $avgBpSystolic,
            'avgBpDiastolic' => $avgBpDiastolic,
            'mostCommonSymptom' => $mostCommonSymptom,
            'activeTreatmentsCount' => $activeTreatmentsCount,
        ]);
    }
}
