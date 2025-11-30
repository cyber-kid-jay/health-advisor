@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 2rem 1rem;">
    <!-- Wizard Container -->
    <div style="background: var(--white); border-radius: 1rem; box-shadow: var(--shadow-lg); overflow: hidden;">
        
        <!-- Wizard Header -->
        <div style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: var(--white); padding: 2rem; text-align: center;">
            <h2 style="margin-bottom: 0.5rem;">Health Assessment Wizard</h2>
            <p style="margin: 0; opacity: 0.9;">Please provide accurate information for the best recommendations</p>
        </div>

        <!-- Wizard Steps Indicator -->
        <div style="display: flex; justify-content: space-between; background: var(--gray-100); padding: 1rem 2rem;">
            <div class="wizard-step-indicator" id="step-indicator-1" data-step="1">
                <strong>Step 1:</strong> Symptoms
            </div>
            <div class="wizard-step-indicator" id="step-indicator-2" data-step="2">
                <strong>Step 2:</strong> Severity
            </div>
            <div class="wizard-step-indicator" id="step-indicator-3" data-step="3">
                <strong>Step 3:</strong> Vital Signs
            </div>
            <div class="wizard-step-indicator" id="step-indicator-4" data-step="4">
                <strong>Step 4:</strong> History
            </div>
        </div>

        <!-- Wizard Content -->
        <form method="POST" action="{{ route('symptom.check') }}" id="wizardForm">
            @csrf
            
            <div style="padding: 2rem;">
                
                <!-- STEP 1: Symptom Selection -->
                <div id="step-content-1" class="wizard-step-content" data-step="1" style="display: block;">
                    <h3>Select Your Symptoms</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Choose all symptoms you are currently experiencing</p>

                    @if ($errors->has('symptoms'))
                        <div style="background: #fee2e2; border-left: 4px solid var(--danger-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;">
                            <strong style="color: var(--danger-color);">{{ $errors->first('symptoms') }}</strong>
                        </div>
                    @endif

                    <!-- Search Box -->
                    <div style="position: relative; margin-bottom: 2rem;">
                        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-600);">🔍</span>
                        <input 
                            type="text" 
                            id="symptomSearch" 
                            placeholder="Search symptoms..." 
                            style="width: 100%; padding: 1rem 1rem 1rem 3rem; border: 2px solid var(--gray-300); border-radius: 0.5rem; font-size: 1rem;"
                        >
                    </div>

                    <!-- Category Buttons -->
                    <h4 style="margin-bottom: 1rem;">Common Categories</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                        <button type="button" class="category-btn active" data-category="all" style="padding: 1rem; background: var(--primary-color); color: var(--white); border: 2px solid var(--primary-color); border-radius: 0.5rem; cursor: pointer; transition: all 0.3s; text-align: center;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📋</div>
                            <div>All Symptoms</div>
                        </button>
                        <button type="button" class="category-btn" data-category="respiratory" style="padding: 1rem; background: var(--white); color: var(--gray-800); border: 2px solid var(--gray-300); border-radius: 0.5rem; cursor: pointer; transition: all 0.3s; text-align: center;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🫁</div>
                            <div>Respiratory</div>
                        </button>
                        <button type="button" class="category-btn" data-category="gastrointestinal" style="padding: 1rem; background: var(--white); color: var(--gray-800); border: 2px solid var(--gray-300); border-radius: 0.5rem; cursor: pointer; transition: all 0.3s; text-align: center;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🍽️</div>
                            <div>Gastrointestinal</div>
                        </button>
                        <button type="button" class="category-btn" data-category="neurological" style="padding: 1rem; background: var(--white); color: var(--gray-800); border: 2px solid var(--gray-300); border-radius: 0.5rem; cursor: pointer; transition: all 0.3s; text-align: center;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🧠</div>
                            <div>Neurological</div>
                        </button>
                    </div>

                    <!-- Symptom List -->
                    <h4 style="margin-bottom: 1rem;">Available Symptoms</h4>
                    <div id="symptomList" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        @foreach ($symptoms as $symptom)
                            @php
                                $checked = in_array($symptom->id, old('symptoms', []));
                            @endphp
                            <label class="symptom-checkbox {{ $checked ? 'checked' : '' }}" data-category="{{ strtolower($symptom->category ?? 'general') }}" style="display: flex; align-items: center; padding: 1rem; background: var(--white); border: 2px solid var(--gray-300); border-radius: 0.5rem; cursor: pointer; transition: all 0.3s;">
                                <input 
                                    type="checkbox" 
                                    name="symptoms[]" 
                                    value="{{ $symptom->id }}" 
                                    style="margin-right: 0.75rem; width: 20px; height: 20px; cursor: pointer;" 
                                    @checked($checked)
                                    onchange="updateSymptomDisplay()"
                                >
                                <span>{{ $symptom->name }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div id="selectedSymptomsDisplay" style="margin-top: 2rem; padding: 1rem; background: #dbeafe; color: #1e40af; border-left: 4px solid var(--primary-color); border-radius: 0.5rem; display: none;">
                        <strong>Selected Symptoms:</strong> <span id="selectedSymptomsList"></span>
                    </div>
                </div>

                <!-- STEP 2: Symptom Severity -->
                <div id="step-content-2" class="wizard-step-content" data-step="2" style="display: none;">
                    <h3>Rate Symptom Severity</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">How severe are your symptoms and how long have you had them?</p>

                    <div id="severityRatings" style="display: grid; gap: 1.5rem;">
                        <div style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                            Please select at least one symptom in Step 1 to continue.
                        </div>
                    </div>
                </div>

                <!-- STEP 3: Vital Signs -->
                <div id="step-content-3" class="wizard-step-content" data-step="3" style="display: none;">
                    <h3>Enter Your Vital Signs</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Provide your current vital measurements for accurate assessment</p>

                    <div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.5rem;">
                        <strong style="color: #92400e;">⚠️ Important:</strong> Ensure measurements are recent and accurate. If you don't have a measurement, you can skip that field.
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                        <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Heart Rate</label>
                            <small style="color: var(--gray-600); display: block; margin-bottom: 0.5rem;">Normal: 60-100 bpm</small>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="number" name="heart_rate" id="heartRate" class="form-control" placeholder="75" min="30" max="200" style="flex: 1;" value="{{ old('heart_rate') }}" onchange="checkVitals()">
                                <span style="font-weight: 600; color: var(--gray-600);">bpm</span>
                            </div>
                        </div>

                        <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Blood Pressure</label>
                            <small style="color: var(--gray-600); display: block; margin-bottom: 0.5rem;">Normal: 120/80 mmHg</small>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="number" name="bp_systolic" id="bpSystolic" class="form-control" placeholder="120" min="70" max="250" style="flex: 1;" value="{{ old('bp_systolic') }}" onchange="checkVitals()">
                                <span>/</span>
                                <input type="number" name="bp_diastolic" id="bpDiastolic" class="form-control" placeholder="80" min="40" max="150" style="flex: 1;" value="{{ old('bp_diastolic') }}" onchange="checkVitals()">
                                <span style="font-weight: 600; color: var(--gray-600);">mmHg</span>
                            </div>
                        </div>

                        <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Temperature</label>
                            <small style="color: var(--gray-600); display: block; margin-bottom: 0.5rem;">Normal: 36.1-37.2°C</small>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="number" name="temperature" id="temperature" class="form-control" placeholder="36.8" step="0.1" min="35" max="42" style="flex: 1;" value="{{ old('temperature') }}" onchange="checkVitals()">
                                <span style="font-weight: 600; color: var(--gray-600);">°C</span>
                            </div>
                        </div>
                    </div>

                    <div id="vitalWarnings" style="margin-top: 2rem;"></div>
                </div>

                <!-- STEP 4: Medical History -->
                <div id="step-content-4" class="wizard-step-content" data-step="4" style="display: none;">
                    <h3>Medical History</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Help us provide better recommendations</p>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600;">Age (optional)</label>
                        <input type="number" name="age" class="form-control" placeholder="e.g., 35" min="0" max="120" value="{{ old('age') }}" style="padding: 0.75rem; border: 2px solid var(--gray-300); border-radius: 0.5rem; width: 100%;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600;">Gender (optional)</label>
                        <select name="gender" class="form-control" style="padding: 0.75rem; border: 2px solid var(--gray-300); border-radius: 0.5rem; width: 100%;">
                            <option value="">Prefer not to say</option>
                            <option value="female" @selected(old('gender') === 'female')>Female</option>
                            <option value="male" @selected(old('gender') === 'male')>Male</option>
                            <option value="other" @selected(old('gender') === 'other')>Other</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600;">Symptom Duration (optional)</label>
                        <input type="text" name="notes" class="form-control" placeholder="e.g., 2 days, 1 week" style="padding: 0.75rem; border: 2px solid var(--gray-300); border-radius: 0.5rem; width: 100%;" value="{{ old('notes') }}">
                    </div>
                </div>

            </div>

            <!-- Navigation Buttons -->
            <div style="display: flex; justify-content: space-between; padding: 2rem; background: var(--gray-100); gap: 1rem;">
                <button type="button" id="prevBtn" class="btn btn-secondary" style="padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; background: var(--white); color: var(--primary-color); border: 2px solid var(--primary-color); transition: all 0.3s; display: none;" onclick="changeStep(-1)">Previous</button>
                <button type="button" id="nextBtn" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; background: var(--primary-color); color: var(--white); transition: all 0.3s; margin-left: auto;" onclick="changeStep(1)">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-success" style="padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; background: var(--success-color); color: var(--white); transition: all 0.3s; display: none;">Submit Assessment</button>
            </div>
        </form>
    </div>
</div>

<style>
    .wizard-step-indicator {
        flex: 1;
        text-align: center;
        padding: 0.5rem;
        color: var(--gray-600);
        font-size: 0.9rem;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }

    .wizard-step-indicator.active {
        color: var(--primary-color);
        font-weight: bold;
        border-bottom-color: var(--primary-color);
    }

    .wizard-step-indicator.completed {
        color: var(--success-color);
        border-bottom-color: var(--success-color);
    }

    .wizard-step-content {
        display: block;
        opacity: 1;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .category-btn {
        cursor: pointer;
    }

    .category-btn:hover {
        opacity: 0.8;
    }

    .symptom-checkbox {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: var(--white);
        border: 2px solid var(--gray-300);
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .symptom-checkbox:hover {
        border-color: var(--primary-color);
        background: var(--gray-100);
    }

    .symptom-checkbox.checked {
        border-color: var(--primary-color);
        background: #eff6ff;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .btn {
        border: none;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0.75rem 1.5rem;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    .btn-secondary:hover {
        background: var(--primary-color);
        color: var(--white);
    }

    .btn-primary {
        background: var(--primary-color);
        color: var(--white);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-success {
        background: var(--success-color);
        color: var(--white);
    }

    .btn-success:hover {
        background: #059669;
    }
</style>

<script>
    let currentStep = 1;
    const totalSteps = 4;
    const selectedSymptoms = new Set();

    function changeStep(direction) {
        // Validate current step before moving forward
        if (direction === 1) {
            if (currentStep === 1 && selectedSymptoms.size === 0) {
                alert('Please select at least one symptom to continue.');
                return;
            }
        }

        // Hide current step content
        const currentContent = document.getElementById(`step-content-${currentStep}`);
        const currentIndicator = document.getElementById(`step-indicator-${currentStep}`);
        
        if (currentContent) {
            currentContent.style.display = 'none';
        }
        if (currentIndicator) {
            currentIndicator.classList.remove('active');
            if (direction === 1) {
                currentIndicator.classList.add('completed');
            }
        }

        // Update current step
        currentStep += direction;

        // Show new step content
        const newContent = document.getElementById(`step-content-${currentStep}`);
        const newIndicator = document.getElementById(`step-indicator-${currentStep}`);
        
        if (newContent) {
            newContent.style.display = 'block';
        }
        if (newIndicator) {
            newIndicator.classList.add('active');
        }

        // Update button visibility
        document.getElementById('prevBtn').style.display = currentStep === 1 ? 'none' : 'inline-block';
        document.getElementById('nextBtn').style.display = currentStep === totalSteps ? 'none' : 'inline-block';
        document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'inline-block' : 'none';

        // Generate severity ratings for step 2
        if (currentStep === 2) {
            generateSeverityRatings();
        }

        // Check vitals for step 3
        if (currentStep === 3) {
            setTimeout(checkVitals, 100);
        }

        window.scrollTo(0, 0);
    }

    function updateSymptomDisplay() {
        const checkboxes = document.querySelectorAll('input[name="symptoms[]"]');
        selectedSymptoms.clear();
        
        checkboxes.forEach(cb => {
            if (cb.checked) {
                selectedSymptoms.add(cb.value);
                cb.parentElement.classList.add('checked');
            } else {
                cb.parentElement.classList.remove('checked');
            }
        });

        const display = document.getElementById('selectedSymptomsDisplay');
        const list = document.getElementById('selectedSymptomsList');
        
        if (selectedSymptoms.size > 0) {
            display.style.display = 'block';
            const labels = [];
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    labels.push(cb.parentElement.querySelector('span').textContent);
                }
            });
            list.textContent = labels.join(', ');
        } else {
            display.style.display = 'none';
        }
    }

    function filterByCategory(btn) {
        const category = btn.getAttribute('data-category');
        
        // Update button styles
        document.querySelectorAll('.category-btn').forEach(b => {
            b.style.background = 'var(--white)';
            b.style.color = 'var(--gray-800)';
            b.style.borderColor = 'var(--gray-300)';
        });
        btn.style.background = 'var(--primary-color)';
        btn.style.color = 'var(--white)';
        btn.style.borderColor = 'var(--primary-color)';

        // Filter symptoms
        const symptoms = document.querySelectorAll('.symptom-checkbox');
        symptoms.forEach(s => {
            if (category === 'all' || s.getAttribute('data-category') === category) {
                s.style.display = 'flex';
            } else {
                s.style.display = 'none';
            }
        });
    }

    // Event listeners for category buttons
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            filterByCategory(btn);
        });
    });

    // Event listener for symptom search
    document.getElementById('symptomSearch').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const symptoms = document.querySelectorAll('.symptom-checkbox');
        symptoms.forEach(s => {
            const text = s.textContent.toLowerCase();
            s.style.display = text.includes(query) ? 'flex' : 'none';
        });
    });

    function generateSeverityRatings() {
        const container = document.getElementById('severityRatings');
        
        if (selectedSymptoms.size === 0) {
            container.innerHTML = '<div style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">Please select at least one symptom in Step 1 to continue.</div>';
            return;
        }

        let html = '';
        const checkboxes = document.querySelectorAll('input[name="symptoms[]"]:checked');
        checkboxes.forEach((cb, idx) => {
            const symptomId = cb.value;
            const label = cb.parentElement.querySelector('span').textContent;
            html += `
                <div style="background: var(--gray-100); padding: 1.5rem; border-radius: 0.5rem;">
                    <h4 style="margin-bottom: 1rem;">${label}</h4>
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Severity</label>
                        <select name="symptom_severity[${symptomId}]" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-300); border-radius: 0.5rem;">
                            <option value="mild">Mild</option>
                            <option value="moderate" selected>Moderate</option>
                            <option value="severe">Severe</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Duration (days)</label>
                        <input type="number" name="symptom_duration[${symptomId}]" placeholder="1" min="0" max="365" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-300); border-radius: 0.5rem;">
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }

    function checkVitals() {
        const warnings = document.getElementById('vitalWarnings');
        if (!warnings) return;
        
        const hr = parseInt(document.getElementById('heartRate')?.value || '0') || null;
        const bpSys = parseInt(document.getElementById('bpSystolic')?.value || '0') || null;
        const bpDia = parseInt(document.getElementById('bpDiastolic')?.value || '0') || null;
        const temp = parseFloat(document.getElementById('temperature')?.value || '0') || null;

        let warningHtml = '';

        if (hr && (hr > 100 || hr < 60)) {
            warningHtml += '<div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;"><strong style="color: #92400e;">⚠️ Your heart rate is outside the normal range (60-100 bpm)</strong></div>';
        }
        if (bpSys && bpDia && (bpSys > 140 || bpDia > 90)) {
            warningHtml += '<div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;"><strong style="color: #92400e;">⚠️ Your blood pressure appears elevated. Consider monitoring and consulting a healthcare provider.</strong></div>';
        }
        if (bpSys && bpDia && (bpSys > 180 || bpDia > 120)) {
            warningHtml += '<div style="background: #fee2e2; border-left: 4px solid var(--danger-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;"><strong style="color: #991b1b;">🚨 EMERGENCY: Your blood pressure is dangerously high. Seek immediate medical attention!</strong></div>';
        }
        if (temp && temp > 38.5) {
            warningHtml += '<div style="background: #fef3c7; border-left: 4px solid var(--warning-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;"><strong style="color: #92400e;">⚠️ You have a fever. Monitor your temperature and stay hydrated.</strong></div>';
        }
        if (temp && temp > 39.4) {
            warningHtml += '<div style="background: #fee2e2; border-left: 4px solid var(--danger-color); padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem;"><strong style="color: #991b1b;">🚨 High fever detected. Consider seeking medical attention if it persists.</strong></div>';
        }

        warnings.innerHTML = warningHtml;
    }

    // Ensure core functions are available on the global `window` object
    // This prevents "function not defined" errors if the script runs in
    // a different scope or is bundled in a way that hides top-level defs.
    window.changeStep = changeStep;
    window.updateSymptomDisplay = updateSymptomDisplay;
    window.filterByCategory = filterByCategory;
    window.generateSeverityRatings = generateSeverityRatings;
    window.checkVitals = checkVitals;

    // Initialize
    updateSymptomDisplay();

    // Ensure the first step indicator and buttons are correct on initial load
    (function initializeWizard() {
        // mark step 1 active
        const firstIndicator = document.getElementById('step-indicator-1');
        if (firstIndicator) firstIndicator.classList.add('active');

        // ensure correct button visibility
        const prev = document.getElementById('prevBtn');
        const next = document.getElementById('nextBtn');
        const submit = document.getElementById('submitBtn');
        if (prev) prev.style.display = 'none';
        if (next) next.style.display = 'inline-block';
        if (submit) submit.style.display = 'none';

        // allow clicking the step indicators to jump to a step
        document.querySelectorAll('.wizard-step-indicator').forEach(ind => {
            ind.addEventListener('click', () => {
                const target = parseInt(ind.getAttribute('data-step')) || 1;
                // hide current
                const _curContent = document.getElementById(`step-content-${currentStep}`);
                if (_curContent) _curContent.style.display = 'none';
                const _curIndicator = document.getElementById(`step-indicator-${currentStep}`);
                if (_curIndicator) _curIndicator.classList.remove('active');
                // set new
                currentStep = target;
                const _newContent = document.getElementById(`step-content-${currentStep}`);
                if (_newContent) _newContent.style.display = 'block';
                const _newIndicator = document.getElementById(`step-indicator-${currentStep}`);
                if (_newIndicator) _newIndicator.classList.add('active');
                document.getElementById('prevBtn').style.display = currentStep === 1 ? 'none' : 'inline-block';
                document.getElementById('nextBtn').style.display = currentStep === totalSteps ? 'none' : 'inline-block';
                document.getElementById('submitBtn').style.display = currentStep === totalSteps ? 'inline-block' : 'none';
                if (currentStep === 2) generateSeverityRatings();
                if (currentStep === 3) setTimeout(checkVitals, 100);
            });
        });
    })();

    // Ensure category filter is applied on initial load so symptoms render correctly
    (function ensureDefaultCategory(){
        try{
            const activeBtn = document.querySelector('.category-btn.active') || document.querySelector('.category-btn[data-category="all"]');
            if (activeBtn) filterByCategory(activeBtn);
            // also ensure symptom search is empty so no accidental filtering
            const search = document.getElementById('symptomSearch');
            if (search && search.value.trim() === '') {
                // trigger search handler to reset visibility
                const evt = new Event('input', { bubbles: true });
                search.dispatchEvent(evt);
            }
        }catch(e){ console.error('ensureDefaultCategory error', e); }
    })();
</script>
@endsection
