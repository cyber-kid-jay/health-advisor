<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Symptom;

class SymptomSeeder extends Seeder
{
    public function run(): void
    {
        $symptoms = [
            ['name' => 'Fever', 'body_part' => 'general', 'severity' => 3, 'category' => 'general', 'description' => 'Raised body temperature above normal.'],
            ['name' => 'Cough', 'body_part' => 'chest', 'severity' => 2, 'category' => 'respiratory', 'description' => 'Persistent cough or irritation in the throat.'],
            ['name' => 'Shortness of breath', 'body_part' => 'chest', 'severity' => 4, 'category' => 'respiratory', 'description' => 'Difficulty breathing or feeling breathless.'],
            ['name' => 'Headache', 'body_part' => 'head', 'severity' => 2, 'category' => 'neurological', 'description' => 'Pain in the head or face.'],
            ['name' => 'Sore throat', 'body_part' => 'throat', 'severity' => 2, 'category' => 'respiratory', 'description' => 'Pain or irritation in the throat.'],
            ['name' => 'Chest pain', 'body_part' => 'chest', 'severity' => 5, 'category' => 'general', 'description' => 'Pain, tightness or discomfort in the chest.'],
            ['name' => 'Nausea', 'body_part' => 'abdomen', 'severity' => 2, 'category' => 'gastrointestinal', 'description' => 'Feeling sick or wanting to vomit.'],
            ['name' => 'Vomiting', 'body_part' => 'abdomen', 'severity' => 3, 'category' => 'gastrointestinal', 'description' => 'Being sick or bringing up stomach contents.'],
            ['name' => 'Diarrhoea', 'body_part' => 'abdomen', 'severity' => 3, 'category' => 'gastrointestinal', 'description' => 'Passing loose or watery stools.'],
            ['name' => 'Fatigue', 'body_part' => 'general', 'severity' => 2, 'category' => 'general', 'description' => 'Feeling very tired or lacking energy.'],
        ];

        foreach ($symptoms as $symptom) {
            Symptom::firstOrCreate(['name' => $symptom['name']], $symptom);
        }
    }
}
