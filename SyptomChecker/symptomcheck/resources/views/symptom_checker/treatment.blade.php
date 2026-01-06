@extends('layouts.app')

@section('title', 'Treatment Recommendations')

@section('content')
<div class="container results-container" style="max-width: 900px; margin: 2rem auto; padding: 2rem;">
    <h1 style="margin-bottom: 0.5rem;">Treatment Recommendations</h1>
    <p style="color: var(--gray-600); margin-bottom: 2rem;">Evidence-based guidance for managing your condition</p>

    <!-- Note -->
    <div class="disclaimer" style="margin-bottom: 2rem;">
        <strong>Note:</strong> These are general recommendations. Always read medication labels carefully and consult a pharmacist or doctor if you have questions.
    </div>

    <!-- Lifestyle & Home Remedies -->
    <div class="treatment-section" style="background: var(--white); padding: 1.5rem; border-radius: 0.75rem; box-shadow: var(--shadow); margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.25rem;">🏠 Lifestyle & Home Remedies</h3>
        <div class="treatment-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Rest & Sleep</h4>
                <p>Get plenty of rest. Aim for 8-10 hours of sleep per night to help your immune system fight the infection.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Stay Hydrated</h4>
                <p>Drink plenty of fluids: water, warm lemon water with honey, herbal tea, or clear broths. Aim for 8-10 glasses daily.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Humidity</h4>
                <p>Use a humidifier or breathe steam from a hot shower to ease congestion and soothe irritated airways.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Saltwater Gargle</h4>
                <p>Gargle with warm salt water (1/2 teaspoon salt in 8 oz water) 3-4 times daily to soothe sore throat.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Wash Hands Frequently</h4>
                <p>Prevent spreading the infection by washing hands regularly with soap and water for at least 20 seconds.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Avoid Irritants</h4>
                <p>Stay away from smoke, strong odors, and other irritants that can worsen symptoms.</p>
            </div>
        </div>
    </div>

    <!-- OTC Medications -->
    <div class="treatment-section" style="background: var(--white); padding: 1.5rem; border-radius: 0.75rem; box-shadow: var(--shadow); margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.25rem;">💊 Over-the-Counter Medications</h3>
        <p style="color: var(--gray-600); margin-bottom: 1.5rem;">These medications can be purchased without a prescription and may help relieve symptoms:</p>

        <div class="treatment-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Paracetamol (Acetaminophen)</h4>
                <p><strong>Purpose:</strong> Reduces fever and relieves pain</p>
                <p><strong>Dosage:</strong> 500-1000mg every 4-6 hours (max 4000mg/24h)</p>
                <p><strong>Examples:</strong> Panadol, Calpol</p>
                <div style="background: #fef3c7; padding: 0.75rem; border-radius: 0.5rem; margin-top: 0.75rem; font-size: 0.85rem;">
                    <strong>Warning:</strong> Do not exceed recommended dose. Avoid if you have liver problems.
                </div>
            </div>

            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Ibuprofen</h4>
                <p><strong>Purpose:</strong> Reduces fever, pain, and inflammation</p>
                <p><strong>Dosage:</strong> 200-400mg every 4-6 hours with food</p>
                <p><strong>Examples:</strong> Nurofen, Advil</p>
                <div style="background: #fef3c7; padding: 0.75rem; border-radius: 0.5rem; margin-top: 0.75rem; font-size: 0.85rem;">
                    <strong>Warning:</strong> Take with food. Avoid if you have stomach ulcers or kidney problems.
                </div>
            </div>

            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Decongestants</h4>
                <p><strong>Purpose:</strong> Relieves nasal congestion</p>
                <p><strong>Examples:</strong> Pseudoephedrine (Sudafed), Phenylephrine</p>
                <p><strong>Note:</strong> Use for no more than 5-7 days</p>
                <div style="background: #fef3c7; padding: 0.75rem; border-radius: 0.5rem; margin-top: 0.75rem; font-size: 0.85rem;">
                    <strong>Warning:</strong> May raise blood pressure. Avoid if you have high blood pressure or heart disease.
                </div>
            </div>

            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Cough Suppressants</h4>
                <p><strong>Purpose:</strong> Reduces coughing</p>
                <p><strong>Active Ingredient:</strong> Dextromethorphan</p>
                <p><strong>Examples:</strong> Robitussin DM, Benylin</p>
                <div style="background: #fef3c7; padding: 0.75rem; border-radius: 0.5rem; margin-top: 0.75rem; font-size: 0.85rem;">
                    <strong>Note:</strong> Only use for dry cough. Don't suppress productive coughs.
                </div>
            </div>

            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Expectorants</h4>
                <p><strong>Purpose:</strong> Helps loosen mucus</p>
                <p><strong>Active Ingredient:</strong> Guaifenesin</p>
                <p><strong>Note:</strong> Best for productive coughs with mucus</p>
            </div>

            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Throat Lozenges</h4>
                <p><strong>Purpose:</strong> Soothes sore throat</p>
                <p><strong>Examples:</strong> Strepsils, Halls</p>
                <p><strong>Note:</strong> Can be used as needed throughout the day</p>
            </div>
        </div>

        <div class="alert alert-warning" style="background: #fef3c7; color: #92400e; border-left: 4px solid var(--warning-color); padding: 1rem; border-radius: 0.5rem; margin-top: 1.5rem;">
            <strong>Important Medication Safety:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                <li>Read all labels carefully before taking any medication</li>
                <li>Don't take multiple products containing the same active ingredient</li>
                <li>Check for drug interactions with your current medications</li>
                <li>Consult a pharmacist if you're pregnant, breastfeeding, or have chronic conditions</li>
                <li>Store medications safely away from children</li>
            </ul>
        </div>
    </div>

    <!-- Diet & Nutrition -->
    <div class="treatment-section" style="background: var(--white); padding: 1.5rem; border-radius: 0.75rem; box-shadow: var(--shadow); margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.25rem;">🍽️ Dietary Recommendations</h3>
        <div class="treatment-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Vitamin C Rich Foods</h4>
                <p>Oranges, strawberries, bell peppers, broccoli, and kiwi may help support immune function.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Warm Soups & Broths</h4>
                <p>Chicken soup, vegetable broth - provides hydration and nutrients. The warmth helps soothe throat.</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Honey & Lemon</h4>
                <p>Add to warm water or tea. Honey soothes throat; lemon provides vitamin C. (Not for children under 1 year)</p>
            </div>
            <div class="treatment-card" style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Ginger Tea</h4>
                <p>May help reduce inflammation and soothe digestive upset that sometimes accompanies colds.</p>
            </div>
        </div>
    </div>

    <!-- Recovery Timeline -->
    <div class="treatment-section" style="background: var(--white); padding: 1.5rem; border-radius: 0.75rem; box-shadow: var(--shadow); margin-bottom: 2rem;">
        <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.25rem;">📅 Expected Recovery Timeline</h3>
        <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem;">
            <h4>Typical Cold Progression:</h4>
            <ul style="margin-left: 1.5rem; line-height: 2;">
                <li><strong>Days 1-3:</strong> Symptoms peak - sore throat, runny nose, fatigue</li>
                <li><strong>Days 4-7:</strong> Symptoms improve - less severe but may still have cough and congestion</li>
                <li><strong>Days 8-10:</strong> Most symptoms resolve - may have lingering cough</li>
                <li><strong>After Day 10:</strong> Should be fully recovered</li>
            </ul>
            <p style="margin-top: 1rem; color: var(--gray-600);">
                If symptoms persist beyond 10 days or worsen, contact your healthcare provider.
            </p>
        </div>
    </div>

    <!-- When to Seek Help -->
    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; border-left: 4px solid var(--danger-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        <strong>When to Seek Emergency Care</strong>
        <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
            <li>Difficulty breathing or shortness of breath</li>
            <li>Chest pain or pressure</li>
            <li>Severe headache or confusion</li>
            <li>Loss of consciousness</li>
            <li>Fever above 39.4°C (103°F) that doesn't respond to medication</li>
            <li>Signs of severe dehydration</li>
        </ul>
    </div>

    <!-- Actions -->
    <div style="text-align: center; margin-top: 2rem; display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('symptom-checker') }}" class="btn btn-primary">Start New Assessment</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Return to Dashboard</a>
    </div>
</div>
@endsection
