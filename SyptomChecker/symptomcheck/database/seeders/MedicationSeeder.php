<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        $medications = [
            // Pain Relief
            [
                'name' => 'Paracetamol',
                'generic_name' => 'Acetaminophen',
                'dosage' => '500mg',
                'type' => 'pain relief',
                'notes' => 'Safe for most people including children and during pregnancy',
                'availability' => 'over-the-counter',
                'side_effects' => ['nausea', 'liver damage at high doses'],
            ],
            [
                'name' => 'Ibuprofen',
                'generic_name' => 'Ibuprofen',
                'dosage' => '200mg',
                'type' => 'pain relief',
                'notes' => 'Do not take if you have stomach ulcers or asthma',
                'availability' => 'over-the-counter',
                'side_effects' => ['stomach upset', 'heartburn', 'dizziness'],
            ],
            [
                'name' => 'Aspirin',
                'generic_name' => 'Acetylsalicylic acid',
                'dosage' => '300mg',
                'type' => 'pain relief',
                'notes' => 'Also helps prevent blood clots',
                'availability' => 'over-the-counter',
                'side_effects' => ['stomach irritation', 'bleeding risk'],
            ],

            // Fever Reducers
            [
                'name' => 'Paracetamol',
                'generic_name' => 'Acetaminophen',
                'dosage' => '500mg',
                'type' => 'fever reducer',
                'notes' => 'Effective for reducing high temperature',
                'availability' => 'over-the-counter',
                'side_effects' => ['nausea'],
            ],

            // Cough & Cold
            [
                'name' => 'Dextromethorphan',
                'generic_name' => 'DXM',
                'dosage' => '10mg',
                'type' => 'cough suppressant',
                'notes' => 'Do not use if cough is productive',
                'availability' => 'over-the-counter',
                'side_effects' => ['drowsiness', 'dizziness'],
            ],
            [
                'name' => 'Guaifenesin',
                'generic_name' => 'Guaifenesin',
                'dosage' => '200mg',
                'type' => 'expectorant',
                'notes' => 'Helps loosen mucus for productive cough',
                'availability' => 'over-the-counter',
                'side_effects' => ['mild nausea'],
            ],

            // Stomach & Digestive
            [
                'name' => 'Omeprazole',
                'generic_name' => 'Omeprazole',
                'dosage' => '20mg',
                'type' => 'antacid',
                'notes' => 'Reduces stomach acid',
                'availability' => 'over-the-counter',
                'side_effects' => ['headache', 'constipation'],
            ],
            [
                'name' => 'Ranitidine',
                'generic_name' => 'Ranitidine',
                'dosage' => '150mg',
                'type' => 'antacid',
                'notes' => 'Reduces stomach acid and heartburn',
                'availability' => 'over-the-counter',
                'side_effects' => ['headache', 'diarrhea'],
            ],
            [
                'name' => 'Bismuth Subsalicylate',
                'generic_name' => 'Bismuth Subsalicylate',
                'dosage' => '262mg',
                'type' => 'anti-diarrheal',
                'notes' => 'Treats diarrhea and stomach upset',
                'availability' => 'over-the-counter',
                'side_effects' => ['dark stools', 'darkening of tongue'],
            ],

            // Allergy
            [
                'name' => 'Cetirizine',
                'generic_name' => 'Cetirizine',
                'dosage' => '10mg',
                'type' => 'antihistamine',
                'notes' => 'Non-drowsy allergy relief',
                'availability' => 'over-the-counter',
                'side_effects' => ['dry mouth', 'fatigue'],
            ],

            // Blood Pressure Support
            [
                'name' => 'Lisinopril',
                'generic_name' => 'Lisinopril',
                'dosage' => '10mg',
                'type' => 'blood pressure reducer',
                'notes' => 'ACE inhibitor for hypertension',
                'availability' => 'prescription',
                'side_effects' => ['dizziness', 'dry cough'],
            ],
            [
                'name' => 'Amlodipine',
                'generic_name' => 'Amlodipine',
                'dosage' => '5mg',
                'type' => 'blood pressure reducer',
                'notes' => 'Calcium channel blocker',
                'availability' => 'prescription',
                'side_effects' => ['swelling', 'dizziness'],
            ],
        ];

        foreach ($medications as $medication) {
            Medication::firstOrCreate(['name' => $medication['name']], $medication);
        }
    }
}
