<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;
use App\Models\Medication;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $treatments = [
            // Cold & Flu Treatments
            [
                'name' => 'Stay Hydrated',
                'description' => 'Drink plenty of fluids to help your body fight the infection and prevent dehydration.',
                'instructions' => '1. Drink at least 8-10 glasses of water daily
2. Include warm liquids like tea, soup, or warm lemon water
3. Avoid alcohol and excessive caffeine
4. Drink fluids even if you don\'t feel thirsty',
                'category' => 'general',
                'duration' => '2-3 weeks',
                'frequency' => 'throughout the day',
            ],
            [
                'name' => 'Get Adequate Rest',
                'description' => 'Allow your body to focus energy on fighting the infection by getting enough sleep.',
                'instructions' => '1. Get 7-9 hours of sleep each night
2. Take naps during the day if possible
3. Avoid strenuous activities
4. Keep your bedroom cool and dark
5. Keep the air moist with a humidifier',
                'category' => 'general',
                'duration' => '1-2 weeks',
                'frequency' => 'daily',
            ],
            [
                'name' => 'Throat Lozenges and Warm Liquids',
                'description' => 'Soothe a sore throat with lozenges and warm beverages.',
                'instructions' => '1. Use over-the-counter throat lozenges containing menthol or honey
2. Gargle with warm salt water (1/2 teaspoon salt in 8oz water) 3-4 times daily
3. Drink warm tea with honey and lemon
4. Avoid hot spicy foods
5. Use a humidifier to keep air moist',
                'category' => 'general',
                'duration' => '1-2 weeks',
                'frequency' => '3-4 times daily',
            ],

            // High Blood Pressure Diet
            [
                'name' => 'DASH Diet - Reduce Sodium',
                'description' => 'The DASH diet helps lower blood pressure by reducing salt intake and increasing nutrients.',
                'instructions' => '1. Limit salt to less than 2,300mg per day (ideally 1,500mg)
2. Avoid processed foods, canned soups, and deli meats
3. Don\'t add salt while cooking or at the table
4. Use herbs and spices for flavoring instead of salt
5. Read nutrition labels and choose low-sodium options
6. Rinse canned vegetables to reduce sodium
7. Prepare meals at home instead of eating out',
                'category' => 'diet',
                'duration' => 'ongoing',
                'frequency' => 'daily',
            ],
            [
                'name' => 'Increase Potassium Rich Foods',
                'description' => 'Foods high in potassium help balance fluids and reduce blood pressure.',
                'instructions' => '1. Eat bananas, oranges, and avocados
2. Include sweet potatoes, spinach, and kale
3. Eat beans and lentils
4. Include fish like salmon (rich in omega-3)
5. Eat nuts and seeds
6. Aim for 4,700mg of potassium daily
7. Consult doctor if on potassium-limiting medications',
                'category' => 'diet',
                'duration' => 'ongoing',
                'frequency' => 'daily',
            ],
            [
                'name' => 'Reduce Saturated Fats',
                'description' => 'Lower saturated fat intake to improve heart health and blood pressure.',
                'instructions' => '1. Choose lean meats and remove visible fat
2. Use low-fat or skim milk instead of whole milk
3. Limit butter and use olive oil instead
4. Avoid fried foods and fatty snacks
5. Include fish twice a week for omega-3 fatty acids
6. Choose whole grains over refined grains
7. Limit cheese and cream-based sauces',
                'category' => 'diet',
                'duration' => 'ongoing',
                'frequency' => 'daily',
            ],

            // High Blood Pressure Exercise
            [
                'name' => 'Regular Aerobic Exercise',
                'description' => 'Aerobic exercises strengthen the heart and help lower blood pressure.',
                'instructions' => '1. Aim for 150 minutes of moderate activity per week
2. Examples: brisk walking, cycling, swimming, jogging
3. Exercise at least 30 minutes most days of the week
4. Start slowly if you\'re not active currently
5. Warm up for 5 minutes before exercising
6. Cool down for 5 minutes after exercising
7. Check with your doctor before starting a new exercise program',
                'category' => 'exercise',
                'duration' => 'ongoing',
                'frequency' => '5-7 days per week',
            ],
            [
                'name' => 'Strength Training',
                'description' => 'Building muscle helps improve metabolism and supports healthy blood pressure.',
                'instructions' => '1. Do strength training 2-3 times per week
2. Exercise all major muscle groups
3. Use weights, resistance bands, or body weight exercises
4. Do 8-12 repetitions per exercise
5. Rest 1-2 minutes between sets
6. Take at least 1 day rest between training sessions
7. Consult a trainer for proper form to prevent injury',
                'category' => 'exercise',
                'duration' => 'ongoing',
                'frequency' => '2-3 times per week',
            ],

            // High Blood Pressure Lifestyle
            [
                'name' => 'Stress Management and Relaxation',
                'description' => 'Chronic stress raises blood pressure; relaxation techniques can help lower it.',
                'instructions' => '1. Practice deep breathing exercises for 10 minutes daily
2. Try meditation or mindfulness for 10-20 minutes daily
3. Practice yoga 2-3 times per week
4. Use progressive muscle relaxation
5. Listen to calming music
6. Spend time in nature
7. Take regular breaks during work
8. Limit caffeine intake (max 2 cups of coffee daily)',
                'category' => 'lifestyle',
                'duration' => 'ongoing',
                'frequency' => 'daily',
            ],
            [
                'name' => 'Limit Alcohol Consumption',
                'description' => 'Excessive alcohol raises blood pressure; limiting intake helps maintain healthy levels.',
                'instructions' => '1. Men: limit to 2 drinks per day maximum
2. Women: limit to 1 drink per day maximum
3. A standard drink is 12oz beer, 5oz wine, or 1.5oz spirits
4. Have alcohol-free days each week
5. Avoid binge drinking
6. Choose lower alcohol beverages
7. Drink water instead of alcohol when possible',
                'category' => 'lifestyle',
                'duration' => 'ongoing',
                'frequency' => 'daily',
            ],
            [
                'name' => 'Maintain Healthy Weight',
                'description' => 'Losing even 10 pounds can significantly lower blood pressure if you\'re overweight.',
                'instructions' => '1. Calculate your healthy weight range with your doctor
2. Aim to lose 1-2 pounds per week if overweight
3. Combine diet changes with regular exercise
4. Track your food intake and calories
5. Eat smaller portions
6. Avoid late-night eating
7. Get weighed weekly to monitor progress',
                'category' => 'lifestyle',
                'duration' => 'ongoing',
                'frequency' => 'daily',
            ],
            [
                'name' => 'Quit Smoking',
                'description' => 'Smoking increases blood pressure and damages blood vessels. Quitting is crucial.',
                'instructions' => '1. Set a quit date and stick to it
2. Tell friends and family about your goal
3. Avoid places where people smoke
4. Use nicotine replacement therapy if needed (patches, gum, lozenges)
5. Consider prescription medications like Champix or Zyban
6. Join a smoking cessation program
7. Call a quit-smoking helpline for support
8. Use stress management techniques instead of smoking',
                'category' => 'lifestyle',
                'duration' => 'ongoing',
                'frequency' => 'as needed',
            ],

            // General Symptom Relief
            [
                'name' => 'Pain and Fever Management',
                'description' => 'Use over-the-counter medications to manage pain and fever safely.',
                'instructions' => '1. Use Paracetamol or Ibuprofen as directed on the package
2. Do not exceed recommended daily doses
3. Space doses at least 4-6 hours apart
4. Alternate between different pain relief types (if approved by doctor)
5. Take with food if you have a sensitive stomach
6. Stop and consult doctor if fever lasts more than 3 days
7. Never give to children without checking appropriate doses',
                'category' => 'medication',
                'duration' => '3-5 days',
                'frequency' => 'as needed',
            ],
        ];

        foreach ($treatments as $treatmentData) {
            Treatment::firstOrCreate(['name' => $treatmentData['name']], $treatmentData);
        }
    }
}
