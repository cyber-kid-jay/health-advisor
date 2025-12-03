@extends('layouts.app')

@section('title', 'SymptomChecker - Your Personal Health Companion')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <h1>Your Personal Health Companion</h1>
    <p>Get instant health advice based on your symptoms and vital signs</p>
    <div class="hero-buttons">
        <a href="{{ route('start') }}" class="btn btn-primary btn-large">Get Started</a>
        <a href="{{ route('blog') }}" class="btn btn-secondary btn-large">Learn More</a>
    </div>
</section>

<div class="container">
    <!-- Critical Medical Disclaimer -->
    <div class="disclaimer disclaimer-critical">
        <h3>IMPORTANT MEDICAL DISCLAIMER</h3>
        <p><strong>This system is NOT a substitute for professional medical advice, diagnosis, or treatment.</strong></p>
        <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
            <li>Always seek the advice of your physician or other qualified health provider</li>
            <li>Never disregard professional medical advice or delay seeking it</li>
            <li>If you think you may have a medical emergency, call 999 (UK) or 911 (US) immediately</li>
            <li>This service provides general information only and should not be relied upon for medical decisions</li>
        </ul>
    </div>

    <!-- Features Section -->
    <h2 class="text-center">How It Works</h2>
    <div class="features">
        <div class="feature-card">
            <div class="feature-icon" style="border-radius: 8px; overflow: hidden; background: #f0f0f0; display: flex; align-items: center; justify-content: center; height: 100px; width: 100px; margin: 0 auto;">
                <img src="{{ asset('images/describe-symptoms.jpg') }}" alt="Describe Your Symptoms" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h3>1. Describe Your Symptoms</h3>
            <p>Select from a comprehensive list of symptoms and rate their severity</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="border-radius: 8px; overflow: hidden; background: #f0f0f0; display: flex; align-items: center; justify-content: center; height: 100px; width: 100px; margin: 0 auto;">
                <img src="{{ asset('images/enter-vital-signs.jpg') }}" alt="Enter Vital Signs" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h3>2. Enter Vital Signs</h3>
            <p>Input your heart rate, blood pressure, and other vital measurements</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="border-radius: 8px; overflow: hidden; background: #f0f0f0; display: flex; align-items: center; justify-content: center; height: 100px; width: 100px; margin: 0 auto;">
                <img src="{{ asset('images/get-analysis.jpg') }}" alt="Get Analysis" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h3>3. Get Analysis</h3>
            <p>Our intelligent system analyzes your data and matches potential conditions</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="border-radius: 8px; overflow: hidden; background: #f0f0f0; display: flex; align-items: center; justify-content: center; height: 100px; width: 100px; margin: 0 auto;">
                <img src="{{ asset('images/recieve-reccomendations.jpg') }}" alt="Receive Recommendations" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h3>4. Receive Recommendations</h3>
            <p>Get personalized treatment suggestions, lifestyle advice, and educational resources</p>
        </div>
    </div>

    <!-- Features & Benefits -->
    <section id="about" style="margin: 4rem 0;">
        <h2 class="text-center mb-4">Why Choose SymptomChecker?</h2>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Accurate Matching</h3>
                <p>Our algorithm matches your symptoms to 20+ medical conditions using weighted analysis to provide the most relevant matches.</p>
            </div>
            <div class="dashboard-card">
                <h3>Quick Assessment</h3>
                <p>Get results in seconds. No waiting for appointments or lengthy consultations. Perfect for quick health checks.</p>
            </div>
            <div class="dashboard-card">
                <h3>Vital Signs Analysis</h3>
                <p>Incorporates your blood pressure, heart rate, and temperature for comprehensive health assessment and risk detection.</p>
            </div>
            <div class="dashboard-card">
                <h3>Educational Resources</h3>
                <p>Learn about conditions, get treatment recommendations, lifestyle tips, and dietary guidance for your health.</p>
            </div>
            <div class="dashboard-card">
                <h3>Medical Guidance</h3>
                <p>Clear indicators of when to seek emergency care, urgent medical attention, or routine check-ups.</p>
            </div>
            <div class="dashboard-card">
                <h3>Privacy Protected</h3>
                <p>Your health data is private and secure. We never share your information with third parties.</p>
            </div>
        </div>
    </section>

    <!-- Covered Conditions -->
    <section style="margin: 4rem 0;">
        <h2 class="text-center mb-4">Conditions We Cover</h2>
        <p class="text-center text-muted" style="margin-bottom: 2rem;">SymptomChecker can help identify symptoms related to the following conditions:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--primary-color);">
                <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">Respiratory</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
                    <li>✓ Common Cold</li>
                    <li>✓ Bronchitis</li>
                    <li>✓ Pneumonia</li>
                    <li>✓ Asthma Attack</li>
                    <li>✓ Allergic Rhinitis</li>
                </ul>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--success-color);">
                <h4 style="color: var(--success-color); margin-bottom: 0.5rem;">Gastrointestinal</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
                    <li>✓ Gastroenteritis</li>
                    <li>✓ Peptic Ulcer</li>
                    <li>✓ Indigestion</li>
                    <li>✓ Nausea & Vomiting</li>
                </ul>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--danger-color);">
                <h4 style="color: var(--danger-color); margin-bottom: 0.5rem;">Cardiovascular</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
                    <li>✓ Hypertension</li>
                    <li>✓ Angina</li>
                    <li>✓ Possible Heart Attack</li>
                    <li>✓ Elevated Blood Pressure</li>
                </ul>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--warning-color);">
                <h4 style="color: var(--warning-color); margin-bottom: 0.5rem;">Neurological</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
                    <li>✓ Migraine</li>
                    <li>✓ Tension Headache</li>
                    <li>✓ Headache (General)</li>
                </ul>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #8b5cf6;">
                <h4 style="color: #8b5cf6; margin-bottom: 0.5rem;">Infections</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
                    <li>✓ Flu (Influenza)</li>
                    <li>✓ Strep Throat</li>
                    <li>✓ Tonsillitis</li>
                    <li>✓ Sinusitis</li>
                    <li>✓ UTI</li>
                </ul>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid #ec4899;">
                <h4 style="color: #ec4899; margin-bottom: 0.5rem;">Endocrine</h4>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
                    <li>✓ Type 2 Diabetes</li>
                    <li>✓ Hypothyroidism</li>
                    <li>✓ Hyperthyroidism</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: var(--white); padding: 3rem 2rem; border-radius: var(--radius-lg); text-align: center; margin: 4rem 0;">
        <h2 style="color: var(--white); margin-bottom: 1rem;">Ready to Check Your Symptoms?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.95;">Get started with a quick symptom assessment in under 5 minutes</p>
        <a href="{{ route('start') }}" class="btn btn-secondary btn-large">Start Now</a>
    </section>

    <!-- FAQ Section -->
    <section style="margin: 4rem 0 6rem 0;">
        <h2 class="text-center mb-4">Frequently Asked Questions</h2>
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); margin-bottom: 1rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Is SymptomChecker a substitute for medical advice?</h4>
                <p style="margin-bottom: 0; color: var(--gray-600);">No. SymptomChecker is an educational tool designed to provide general health information. Always consult with a healthcare professional for medical advice, diagnosis, or treatment.</p>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); margin-bottom: 1rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">How accurate are the results?</h4>
                <p style="margin-bottom: 0; color: var(--gray-600);">Our system matches symptoms to conditions using a weighted algorithm based on medical data. Results are for informational purposes only and should not be used as a definitive diagnosis.</p>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); margin-bottom: 1rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">What if I see a medical emergency warning?</h4>
                <p style="margin-bottom: 0; color: var(--gray-600);">If you see an "Emergency" warning, call 999 (UK) or 911 (US) immediately. Do not delay seeking emergency medical care.</p>
            </div>
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); margin-bottom: 1rem; border-left: 4px solid var(--primary-color);">
                <h4 style="margin-bottom: 0.5rem;">Is my data private?</h4>
                <p style="margin-bottom: 0; color: var(--gray-600);">Yes. Your health information is never shared with third parties and is kept confidential according to medical privacy standards.</p>
            </div>
        </div>
    </section>
</div>

<script>
    // Simple mobile menu toggle (if needed)
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        
        if (navToggle) {
            navToggle.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
        }
    });
</script>
@endsection
