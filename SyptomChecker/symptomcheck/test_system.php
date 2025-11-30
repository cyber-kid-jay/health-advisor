<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SYMPTOMS ===\n";
$symptoms = \App\Models\Symptom::all();
foreach($symptoms as $s) {
  echo $s->id . ': ' . $s->name . "\n";
}

echo "\n=== CONDITIONS ===\n";
$conditions = \App\Models\Condition::all();
foreach($conditions as $c) {
  echo $c->id . ': ' . $c->name . ' (treatments: ' . $c->treatments->count() . ')', "\n";
}

echo "\n=== TREATMENTS ===\n";
$treatments = \App\Models\Treatment::all();
foreach($treatments as $t) {
  echo $t->id . ': ' . $t->name . ' (' . $t->category . ')', "\n";
}

echo "\n=== CONSULTATIONS IN DB ===\n";
$consultations = \App\Models\Consultation::with('symptoms', 'healthVital')->get();
echo "Total consultations: " . $consultations->count() . "\n";
foreach($consultations->take(3) as $c) {
  echo "\nConsultation #" . $c->id . ":\n";
  echo "  Age: " . ($c->age ?? 'N/A') . "\n";
  echo "  Gender: " . ($c->gender ?? 'N/A') . "\n";
  echo "  Symptoms: " . implode(', ', $c->symptoms->pluck('name')->toArray()) . "\n";
  if ($c->healthVital) {
    echo "  BP: " . $c->healthVital->blood_pressure_systolic . "/" . $c->healthVital->blood_pressure_diastolic . " mmHg\n";
    echo "  HR: " . ($c->healthVital->heart_rate ?? 'N/A') . " BPM\n";
    echo "  Temp: " . ($c->healthVital->temperature ?? 'N/A') . "°C\n";
  }
}
