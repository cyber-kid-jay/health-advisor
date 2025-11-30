<?php
// Simple manual test runner that calls the SymptomCheckerController::analyze
// and saves rendered HTML outputs and prints DB summaries.

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Models\Symptom;
use App\Models\Consultation;
use App\Models\HealthVital;
use App\Http\Controllers\SymptomCheckerController;

// Fetch symptoms to map names to IDs
$symptoms = Symptom::all()->keyBy('name')->map->id->toArray();

// Prepare test cases
$tests = [
    'Common Cold (Fever + Cough)' => [
        'symptoms' => [ $symptoms['Fever'] ?? null, $symptoms['Cough'] ?? null ],
        'age' => 30,
        'gender' => 'female',
        'notes' => 'Started with sore throat',
        'bp_systolic' => null,
        'bp_diastolic' => null,
        'heart_rate' => 78,
        'temperature' => 38.2,
    ],

    'Possible Heart Attack (Chest pain + Shortness of breath)' => [
        'symptoms' => [ $symptoms['Chest pain'] ?? null, $symptoms['Shortness of breath'] ?? null ],
        'age' => 62,
        'gender' => 'male',
        'notes' => 'Severe chest tightness and sweating',
        'bp_systolic' => 160,
        'bp_diastolic' => 100,
        'heart_rate' => 110,
        'temperature' => 36.8,
    ],

    'Hypertension Scenario (Headache + High BP)' => [
        'symptoms' => [ $symptoms['Headache'] ?? null ],
        'age' => 54,
        'gender' => 'female',
        'notes' => 'Occasional headaches and dizzy spells',
        'bp_systolic' => 150,
        'bp_diastolic' => 95,
        'heart_rate' => 85,
        'temperature' => 36.7,
    ],
];

$outputDir = __DIR__ . '/test_outputs';
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0755, true);
}

$controller = $app->make(SymptomCheckerController::class);

foreach ($tests as $title => $data) {
    echo "Running test: $title\n";

    // Clean nulls in symptoms
    $data['symptoms'] = array_values(array_filter($data['symptoms'], function ($v) { return !is_null($v); }));

    $request = Request::create('/check', 'POST', $data);

    try {
        // Call controller method directly
        $response = $controller->analyze($request);

        // If response is a view, render to string
        if (is_object($response) && method_exists($response, 'render')) {
            $html = $response->render();
        } elseif (is_string($response)) {
            $html = $response;
        } else {
            $html = print_r($response, true);
        }

        $filename = $outputDir . '/' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($title)) . '.html';
        file_put_contents($filename, $html);

        echo "  → Rendered HTML saved to: $filename\n";

        // Find the consultation created for this test by matching the unique notes field
        $consultation = Consultation::where('notes', $data['notes'])->orderBy('id', 'desc')->first();
        if ($consultation) {
            echo "  → Consultation ID: {$consultation->id}, age: {$consultation->age}, gender: {$consultation->gender}\n";
            echo "    symptoms stored: ";
            print_r($consultation->symptom_ids);

            $vital = $consultation->healthVital()->first();
            if ($vital) {
                echo "    Vitals: BP {$vital->blood_pressure_systolic}/{$vital->blood_pressure_diastolic}, HR {$vital->heart_rate}, Temp {$vital->temperature}\n";
                echo "    BP status: {$vital->getBloodPressureStatus()}, HR status: {$vital->getHeartRateStatus()}\n";
            } else {
                echo "    No vitals stored.\n";
            }
        } else {
            echo "  → No consultation record found for notes: {$data['notes']}\n";
        }

    } catch (\Exception $e) {
        echo "  → Test failed: " . $e->getMessage() . "\n";
    }

    echo "\n";
}

echo "All tests finished. Outputs saved to: $outputDir\n";
