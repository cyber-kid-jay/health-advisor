<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;
use App\Models\Symptom;
use App\Models\Treatment;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        $conditionsData = [
            'Common cold' => [
                'description' => 'A mild viral infection of the nose and throat.',
                'advice' => 'Rest, drink plenty of fluids and use simple painkillers. See a GP if symptoms last more than 3 weeks or get much worse.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Cough' => 2,
                    'Sore throat' => 3,
                    'Fever' => 1,
                    'Fatigue' => 1,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Throat Lozenges and Warm Liquids',
                    'Pain and Fever Management',
                ],
            ],
            'Flu (influenza)' => [
                'description' => 'A common viral infection that can cause high temperature, aches and fatigue.',
                'advice' => 'Rest at home and drink fluids. Seek medical help if you are very unwell, pregnant, elderly or have a long‑term condition.',
                'urgency' => 'urgent',
                'symptoms' => [
                    'Fever' => 4,
                    'Cough' => 3,
                    'Headache' => 3,
                    'Fatigue' => 3,
                    'Sore throat' => 2,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Throat Lozenges and Warm Liquids',
                    'Pain and Fever Management',
                ],
            ],
            'Bronchitis' => [
                'description' => 'Inflammation of the air tubes that carry air to your lungs, often causing a persistent cough.',
                'advice' => 'Rest and drink plenty of fluids. Most cases improve within 3 weeks. See a GP if your cough is severe or lasts longer.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Cough' => 5,
                    'Shortness of breath' => 3,
                    'Fever' => 2,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Throat Lozenges and Warm Liquids',
                    'Pain and Fever Management',
                ],
            ],
            'Pneumonia' => [
                'description' => 'Infection that causes inflammation in the lungs, making it harder to get oxygen.',
                'advice' => 'This requires urgent medical attention. Seek help if you have high fever, severe shortness of breath, or chest pain.',
                'urgency' => 'urgent',
                'symptoms' => [
                    'Fever' => 5,
                    'Cough' => 4,
                    'Shortness of breath' => 5,
                    'Chest pain' => 3,
                    'Fatigue' => 4,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Pain and Fever Management',
                ],
            ],
            'Asthma attack' => [
                'description' => 'Sudden worsening of asthma symptoms characterized by breathing difficulty and airway narrowing.',
                'advice' => 'Use rescue inhaler immediately. Seek urgent help if symptoms do not improve in 15 minutes or you have severe difficulty breathing.',
                'urgency' => 'urgent',
                'symptoms' => [
                    'Shortness of breath' => 5,
                    'Cough' => 3,
                    'Chest pain' => 3,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Get Adequate Rest',
                    'Stress Management and Relaxation',
                ],
            ],
            'Allergic rhinitis' => [
                'description' => 'Allergic reaction causing inflammation of the nasal passages and sinus tissues.',
                'advice' => 'Avoid allergens where possible. Antihistamines and nasal sprays can help. See a GP if symptoms persist or worsen.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Sore throat' => 2,
                    'Headache' => 2,
                    'Cough' => 1,
                    'Fatigue' => 1,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Pain and Fever Management',
                ],
            ],
            'Gastroenteritis (stomach bug)' => [
                'description' => 'Infection of the stomach and intestines causing vomiting and diarrhoea.',
                'advice' => 'Drink small sips of fluid often to avoid dehydration. Seek help urgently if you cannot keep fluids down or feel very weak.',
                'urgency' => 'urgent',
                'symptoms' => [
                    'Nausea' => 3,
                    'Vomiting' => 4,
                    'Diarrhoea' => 4,
                    'Fever' => 2,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Pain and Fever Management',
                ],
            ],
            'Peptic ulcer' => [
                'description' => 'Open sore in the stomach lining or small intestine, causing abdominal pain and discomfort.',
                'advice' => 'Avoid spicy food and alcohol. Take antacids for relief. See a GP if pain is severe or you vomit blood.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Nausea' => 2,
                    'Vomiting' => 2,
                    'Headache' => 1,
                    'Fatigue' => 1,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Pain and Fever Management',
                ],
            ],
            'Migraine' => [
                'description' => 'Intense, debilitating headache often accompanied by sensitivity to light and nausea.',
                'advice' => 'Rest in a dark, quiet room. Take painkillers early. Seek urgent help if this is worse than usual or accompanied by vision changes.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Headache' => 5,
                    'Nausea' => 3,
                    'Vomiting' => 2,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Get Adequate Rest',
                    'Stress Management and Relaxation',
                    'Pain and Fever Management',
                ],
            ],
            'Tension headache' => [
                'description' => 'Most common type of headache, usually caused by stress and muscle tension.',
                'advice' => 'Rest, relax neck muscles, and use painkillers if needed. Try stress management techniques.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Headache' => 4,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Get Adequate Rest',
                    'Stress Management and Relaxation',
                    'Pain and Fever Management',
                ],
            ],
            'Urinary tract infection' => [
                'description' => 'Infection of the urinary system causing pain and discomfort during urination.',
                'advice' => 'Drink plenty of water and see a GP for antibiotics if symptoms persist or worsen.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Fever' => 2,
                    'Fatigue' => 2,
                    'Nausea' => 1,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Pain and Fever Management',
                ],
            ],
            'Possible heart attack' => [
                'description' => 'Serious reduction in blood supply to the heart muscle.',
                'advice' => 'This is an emergency. Call your local emergency number immediately.',
                'urgency' => 'emergency',
                'symptoms' => [
                    'Chest pain' => 5,
                    'Shortness of breath' => 5,
                    'Nausea' => 2,
                    'Fatigue' => 3,
                ],
                'treatments' => [],
            ],
            'Angina' => [
                'description' => 'Chest pain caused by reduced blood flow to the heart.',
                'advice' => 'Rest immediately and take prescribed medication. Seek emergency help if pain is severe or does not improve with rest.',
                'urgency' => 'urgent',
                'symptoms' => [
                    'Chest pain' => 5,
                    'Shortness of breath' => 4,
                    'Fatigue' => 2,
                    'Nausea' => 1,
                ],
                'treatments' => [
                    'Get Adequate Rest',
                    'Stress Management and Relaxation',
                ],
            ],
            'Hypertension (High Blood Pressure)' => [
                'description' => 'Elevated blood pressure that can lead to serious health complications if untreated.',
                'advice' => 'Monitor your blood pressure regularly, make lifestyle changes, and consult a doctor for medication if needed.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Headache' => 2,
                    'Fatigue' => 1,
                ],
                'treatments' => [
                    'DASH Diet - Reduce Sodium',
                    'Increase Potassium Rich Foods',
                    'Reduce Saturated Fats',
                    'Regular Aerobic Exercise',
                    'Stress Management and Relaxation',
                    'Limit Alcohol Consumption',
                    'Maintain Healthy Weight',
                    'Quit Smoking',
                ],
            ],
            'Hypothyroidism' => [
                'description' => 'Underactive thyroid gland producing insufficient thyroid hormone, slowing metabolism.',
                'advice' => 'See a GP for blood tests. Treatment involves thyroid hormone replacement therapy.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Fatigue' => 5,
                    'Headache' => 2,
                ],
                'treatments' => [
                    'Get Adequate Rest',
                    'Maintain Healthy Weight',
                ],
            ],
            'Hyperthyroidism' => [
                'description' => 'Overactive thyroid gland producing excess thyroid hormone, speeding up metabolism.',
                'advice' => 'See a GP for blood tests and treatment options. May involve medication or other interventions.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Fatigue' => 3,
                    'Headache' => 2,
                    'Fever' => 1,
                ],
                'treatments' => [
                    'Get Adequate Rest',
                    'Stress Management and Relaxation',
                ],
            ],
            'Strep throat (bacterial pharyngitis)' => [
                'description' => 'Bacterial infection of the throat causing severe sore throat and fever.',
                'advice' => 'See a GP for antibiotics. Avoid close contact with others to prevent spread.',
                'urgency' => 'urgent',
                'symptoms' => [
                    'Sore throat' => 5,
                    'Fever' => 4,
                    'Headache' => 3,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Throat Lozenges and Warm Liquids',
                    'Pain and Fever Management',
                ],
            ],
            'Tonsillitis' => [
                'description' => 'Inflammation of the tonsils usually caused by viral or bacterial infection.',
                'advice' => 'Rest and drink fluids. See a GP if pain is severe or lasts more than a few days.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Sore throat' => 5,
                    'Fever' => 3,
                    'Headache' => 2,
                    'Fatigue' => 2,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Get Adequate Rest',
                    'Throat Lozenges and Warm Liquids',
                    'Pain and Fever Management',
                ],
            ],
            'Sinusitis' => [
                'description' => 'Inflammation of the sinuses causing facial pain, congestion, and headache.',
                'advice' => 'Use saline nasal drops, decongestants, and pain relief. See a GP if symptoms persist beyond 10 days.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Headache' => 4,
                    'Fever' => 2,
                    'Sore throat' => 1,
                    'Fatigue' => 1,
                ],
                'treatments' => [
                    'Stay Hydrated',
                    'Pain and Fever Management',
                ],
            ],
            'Diabetes (Type 2)' => [
                'description' => 'Condition where the body cannot effectively use or produce enough insulin to regulate blood sugar.',
                'advice' => 'Monitor blood sugar levels, eat a balanced diet, exercise regularly, and see a GP for medication if needed.',
                'urgency' => 'routine',
                'symptoms' => [
                    'Fatigue' => 4,
                    'Nausea' => 1,
                    'Fever' => 1,
                ],
                'treatments' => [
                    'DASH Diet - Reduce Sodium',
                    'Increase Potassium Rich Foods',
                    'Regular Aerobic Exercise',
                    'Maintain Healthy Weight',
                ],
            ],
        ];

        foreach ($conditionsData as $name => $data) {
            $condition = Condition::firstOrCreate(
                ['name' => $name],
                [
                    'description' => $data['description'],
                    'advice' => $data['advice'],
                    'urgency_level' => $data['urgency'],
                ]
            );

            $symptomWeights = [];
            foreach ($data['symptoms'] as $symptomName => $weight) {
                $symptom = Symptom::where('name', $symptomName)->first();
                if ($symptom) {
                    $symptomWeights[$symptom->id] = ['weight' => $weight];
                }
            }

            if (!empty($symptomWeights)) {
                $condition->symptoms()->syncWithoutDetaching($symptomWeights);
            }

            // Attach treatments
            $treatmentIds = [];
            foreach ($data['treatments'] as $treatmentName) {
                $treatment = Treatment::where('name', $treatmentName)->first();
                if ($treatment) {
                    $treatmentIds[] = $treatment->id;
                }
            }

            if (!empty($treatmentIds)) {
                $condition->treatments()->syncWithoutDetaching($treatmentIds);
            }
        }
    }
}
