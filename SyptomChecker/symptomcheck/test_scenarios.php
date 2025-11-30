<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST: Simulating High Blood Pressure Detection ===\n\n";

// Create a test consultation with high BP
$consultation = \App\Models\Consultation::create([
    'age' => 45,
    'gender' => 'male',
    'notes' => 'Experiencing headaches and fatigue',
    'result_summary' => [],
]);

// Attach symptoms
$symptoms = \App\Models\Symptom::whereIn('name', ['Headache', 'Fatigue'])->pluck('id');
$consultation->symptoms()->sync($symptoms);

// Create health vital with HIGH blood pressure
$vital = \App\Models\HealthVital::create([
    'consultation_id' => $consultation->id,
    'blood_pressure_systolic' => 155,
    'blood_pressure_diastolic' => 98,
    'heart_rate' => 78,
    'temperature' => 36.8,
]);

echo "Created Test Consultation #" . $consultation->id . "\n";
echo "Age: " . $consultation->age . "\n";
echo "Gender: " . $consultation->gender . "\n";
echo "Notes: " . $consultation->notes . "\n";
echo "Symptoms: " . implode(', ', $consultation->symptoms->pluck('name')->toArray()) . "\n\n";

echo "Health Vitals:\n";
echo "  Blood Pressure: " . $vital->blood_pressure_systolic . "/" . $vital->blood_pressure_diastolic . " mmHg\n";
echo "  Status: " . $vital->getBloodPressureStatus() . "\n";
echo "  Is High? " . ($vital->isBloodPressureHigh() ? 'YES ⚠️' : 'NO') . "\n";
echo "  Heart Rate: " . $vital->heart_rate . " BPM (" . $vital->getHeartRateStatus() . ")\n";
echo "  Temperature: " . $vital->temperature . "°C (" . ($vital->hasElevatedTemperature() ? 'FEVER' : 'NORMAL') . ")\n\n";

echo "=== TEST: Simulating Common Cold ===\n\n";

$consultation2 = \App\Models\Consultation::create([
    'age' => 28,
    'gender' => 'female',
    'notes' => 'Started 2 days ago',
    'result_summary' => [],
]);

$coldSymptoms = \App\Models\Symptom::whereIn('name', ['Cough', 'Sore throat', 'Fever'])->pluck('id');
$consultation2->symptoms()->sync($coldSymptoms);

$vital2 = \App\Models\HealthVital::create([
    'consultation_id' => $consultation2->id,
    'blood_pressure_systolic' => 118,
    'blood_pressure_diastolic' => 76,
    'heart_rate' => 72,
    'temperature' => 37.8,
]);

echo "Created Test Consultation #" . $consultation2->id . "\n";
echo "Age: " . $consultation2->age . "\n";
echo "Gender: " . $consultation2->gender . "\n";
echo "Notes: " . $consultation2->notes . "\n";
echo "Symptoms: " . implode(', ', $consultation2->symptoms->pluck('name')->toArray()) . "\n\n";

echo "Health Vitals:\n";
echo "  Blood Pressure: " . $vital2->blood_pressure_systolic . "/" . $vital2->blood_pressure_diastolic . " mmHg\n";
echo "  Status: " . $vital2->getBloodPressureStatus() . "\n";
echo "  Heart Rate: " . $vital2->heart_rate . " BPM (" . $vital2->getHeartRateStatus() . ")\n";
echo "  Temperature: " . $vital2->temperature . "°C (" . ($vital2->hasElevatedTemperature() ? 'FEVER' : 'NORMAL') . ")\n\n";

echo "=== Verifying Relationships ===\n\n";

$condition = \App\Models\Condition::where('name', 'Hypertension (High Blood Pressure)')->first();
echo "Hypertension Condition:\n";
echo "  Treatments: " . $condition->treatments->count() . "\n";
foreach($condition->treatments as $treatment) {
    echo "    - " . $treatment->name . " (" . $treatment->category . ")\n";
}

echo "\nCommon Cold Condition:\n";
$coldCondition = \App\Models\Condition::where('name', 'Common cold')->first();
echo "  Treatments: " . $coldCondition->treatments->count() . "\n";
foreach($coldCondition->treatments as $treatment) {
    echo "    - " . $treatment->name . " (" . $treatment->category . ")\n";
}

echo "\n=== System Test Complete ===\n";
