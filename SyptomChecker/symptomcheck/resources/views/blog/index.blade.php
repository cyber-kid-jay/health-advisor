@extends('layouts.app')

@section('title', 'Blog - SymptomChecker')

@section('content')
<style>
    .hero-blog {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #ffffff;
        padding: 3rem 2rem;
        text-align: center;
    }

    .hero-blog h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: white
    }

    .hero-blog p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .blog-layout {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 3rem;
        margin-top: 2rem;
    }

    .search-filter {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .search-box {
        position: relative;
        margin-bottom: 1rem;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 0.75rem 0.75rem 2.5rem;
        border: 2px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .category-filters {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .category-tag {
        padding: 0.5rem 1rem;
        border: 2px solid #d1d5db;
        border-radius: 2rem;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .category-tag:hover,
    .category-tag.active {
        border-color: #2563eb;
        background: #2563eb;
        color: #ffffff;
    }

    .blog-posts {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .blog-card {
        background: #ffffff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .blog-card-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .blog-card-content {
        padding: 2rem;
    }

    .blog-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #4b5563;
    }

    .blog-card h3 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
        color: #1f2937;
    }

    .blog-card p {
        color: #4b5563;
        margin-bottom: 1rem;
        line-height: 1.7;
    }

    .blog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .blog-tags {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .tag {
        padding: 0.25rem 0.75rem;
        background: #f3f4f6;
        border-radius: 1rem;
        font-size: 0.75rem;
        color: #4b5563;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .sidebar-card {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .sidebar-card h3 {
        margin-bottom: 1rem;
        color: #2563eb;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.5rem;
    }

    .popular-post {
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .popular-post:last-child {
        border-bottom: none;
    }

    .popular-post:hover {
        background: #f3f4f6;
        margin: 0 -0.5rem;
        padding: 1rem 0.5rem;
        border-radius: 0.5rem;
    }

    .popular-post h4 {
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
        color: #1f2937;
    }

    .popular-post p {
        font-size: 0.8rem;
        color: #4b5563;
    }

    .newsletter {
        text-align: center;
    }

    .newsletter input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #d1d5db;
        border-radius: 0.5rem;
        margin: 1rem 0;
    }

    .disclaimer {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        margin: 2rem 0;
        border-radius: 0.5rem;
        font-size: 0.9rem;
    }

    .featured-post {
        background: #ffffff;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        margin-bottom: 3rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .featured-image {
        background-size: cover;
        background-position: center;
        min-height: 350px;
    }

    .featured-content {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .featured-badge {
        background: #f59e0b;
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: bold;
        display: inline-block;
        width: fit-content;
        margin-bottom: 1rem;
    }

    .featured-content h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #1f2937;
    }

    @media (max-width: 968px) {
        .blog-layout {
            grid-template-columns: 1fr;
        }

        .featured-post {
            grid-template-columns: 1fr;
        }

        .featured-image {
            min-height: 200px;
        }
    }
</style>

<div class="hero-blog">
    <h1>Health & Wellness Blog</h1>
    <p>Expert insights, tips, and the latest health information</p>
</div>

<div class="container">
    <div class="disclaimer">
        <strong>Medical Disclaimer:</strong> The information provided in these articles is for educational purposes only and should not be considered medical advice. Always consult with a qualified healthcare professional for medical concerns.
    </div>

    <div class="search-filter">
        <!-- <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search articles..." id="searchInput">
        </div> -->
        <div class="category-filters">
            <span class="category-tag active" onclick="filterCategory(this, 'all')">All</span>
            <span class="category-tag" onclick="filterCategory(this, 'prevention')">Prevention</span>
            <span class="category-tag" onclick="filterCategory(this, 'nutrition')">Nutrition</span>
            <span class="category-tag" onclick="filterCategory(this, 'fitness')">Fitness</span>
            <span class="category-tag" onclick="filterCategory(this, 'mental-health')">Mental Health</span>
            <span class="category-tag" onclick="filterCategory(this, 'seasonal')">Seasonal</span>
        </div>
    </div>

    <div class="featured-post">
        <div class="featured-image" style="background-image: url('https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=800&h=600&fit=crop');"></div>
        <div class="featured-content">
            <span class="featured-badge">FEATURED</span>
            <h2>10 Evidence-Based Ways to Boost Your Immune System</h2>
            <p style="color: #4b5563; margin-bottom: 1.5rem;">
                Discover scientifically proven methods to strengthen your body's natural defenses and maintain optimal health throughout the year.
            </p>
            <div class="blog-meta">
                <span>📅 Nov 20, 2025</span>
                <span>👤 Dr. Sarah Mitchell</span>
                <span>⏱️ 8 min read</span>
            </div>
            <a href="https://www.mayoclinic.org/healthy-lifestyle/nutrition-and-healthy-eating/expert-answers/immune-system/faq-20057645" target="_blank" rel="noopener" class="btn btn-primary" style="width: fit-content; margin-top: 1rem;">Read Article</a>
        </div>
    </div>

    <div class="blog-layout">
        <div class="blog-posts">
            <a href="https://www.cdc.gov/flu/prevent/actions-to-take.html" target="_blank" rel="noopener" class="blog-card" data-category="seasonal">
                <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?w=800&h=500&fit=crop" alt="Person with cold symptoms" class="blog-card-image">
                <div class="blog-card-content">
                    <div class="blog-meta">
                        <span>📅 Nov 18, 2025</span>
                        <span>👤 Dr. James Wilson</span>
                        <span>⏱️ 6 min read</span>
                    </div>
                    <h3>Winter Wellness: Preventing Common Cold and Flu</h3>
                    <p>
                        As temperatures drop, learn essential strategies to protect yourself and your family from seasonal illnesses. From proper handwashing techniques to understanding when to seek medical care.
                    </p>
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="tag">Prevention</span>
                            <span class="tag">Seasonal Health</span>
                            <span class="tag">Respiratory</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="https://www.health.harvard.edu/staying-healthy/foods-that-fight-inflammation" target="_blank" rel="noopener" class="blog-card" data-category="nutrition">
                <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800&h=500&fit=crop" alt="Healthy salad bowl" class="blog-card-image">
                <div class="blog-card-content">
                    <div class="blog-meta">
                        <span>📅 Nov 15, 2025</span>
                        <span>👤 Emily Chen, RD</span>
                        <span>⏱️ 7 min read</span>
                    </div>
                    <h3>The Ultimate Guide to Anti-Inflammatory Foods</h3>
                    <p>
                        Chronic inflammation is linked to many health conditions. Discover which foods can help reduce inflammation and support overall wellness, backed by nutritional science.
                    </p>
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="tag">Nutrition</span>
                            <span class="tag">Diet</span>
                            <span class="tag">Prevention</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="https://www.mayoclinic.org/healthy-lifestyle/stress-management/in-depth/stress-relief/art-20044456" target="_blank" rel="noopener" class="blog-card" data-category="mental-health">
                <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=800&h=500&fit=crop" alt="Person meditating peacefully" class="blog-card-image">
                <div class="blog-card-content">
                    <div class="blog-meta">
                        <span>📅 Nov 12, 2025</span>
                        <span>👤 Dr. Michael Torres</span>
                        <span>⏱️ 5 min read</span>
                    </div>
                    <h3>Managing Stress: Practical Techniques That Work</h3>
                    <p>
                        Stress affects both mental and physical health. Learn evidence-based techniques including mindfulness, breathing exercises, and lifestyle modifications to manage daily stress effectively.
                    </p>
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="tag">Mental Health</span>
                            <span class="tag">Stress</span>
                            <span class="tag">Wellness</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="https://www.cdc.gov/physicalactivity/basics/adults/index.htm" target="_blank" rel="noopener" class="blog-card" data-category="fitness">
                <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=800&h=500&fit=crop" alt="Person exercising outdoors" class="blog-card-image">
                <div class="blog-card-content">
                    <div class="blog-meta">
                        <span>📅 Nov 10, 2025</span>
                        <span>👤 Lisa Anderson, PT</span>
                        <span>⏱️ 6 min read</span>
                    </div>
                    <h3>Starting a Fitness Routine: A Beginner's Guide</h3>
                    <p>
                        New to exercise? This comprehensive guide covers everything from setting realistic goals to choosing activities you'll enjoy. Learn how to build a sustainable fitness habit safely.
                    </p>
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="tag">Fitness</span>
                            <span class="tag">Exercise</span>
                            <span class="tag">Beginners</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="https://www.mayoclinic.org/healthy-lifestyle/preventive-health/in-depth/preventive-care/art-20045699" target="_blank" rel="noopener" class="blog-card" data-category="prevention">
                <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=800&h=500&fit=crop" alt="Medical checkup" class="blog-card-image">
                <div class="blog-card-content">
                    <div class="blog-meta">
                        <span>📅 Nov 8, 2025</span>
                        <span>👤 Dr. Rebecca Park</span>
                        <span>⏱️ 4 min read</span>
                    </div>
                    <h3>Understanding Preventive Care: What You Need to Know</h3>
                    <p>
                        Preventive care can catch health issues early when they're most treatable. Learn which screenings and checkups are recommended for your age group and risk factors.
                    </p>
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="tag">Prevention</span>
                            <span class="tag">Screenings</span>
                            <span class="tag">Healthcare</span>
                        </div>
                    </div>
                </div>
            </a>

            <a href="https://www.nhlbi.nih.gov/education/dash-eating-plan" target="_blank" rel="noopener" class="blog-card" data-category="nutrition">
                <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800&h=500&fit=crop" alt="Fresh fruits and vegetables" class="blog-card-image">
                <div class="blog-card-content">
                    <div class="blog-meta">
                        <span>📅 Nov 5, 2025</span>
                        <span>👤 David Kumar, MD</span>
                        <span>⏱️ 7 min read</span>
                    </div>
                    <h3>Blood Pressure and Diet: Foods That Help</h3>
                    <p>
                        High blood pressure affects millions worldwide. Discover how dietary changes, including the DASH diet principles, can naturally support healthy blood pressure levels.
                    </p>
                    <div class="blog-footer">
                        <div class="blog-tags">
                            <span class="tag">Nutrition</span>
                            <span class="tag">Heart Health</span>
                            <span class="tag">Blood Pressure</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <aside class="sidebar">
            <div class="sidebar-card">
                <h3>Popular Articles</h3>
                <a href="https://www.mayoclinic.org/symptoms/chest-pain/basics/when-to-see-doctor/sym-20050013" target="_blank" rel="noopener" class="popular-post">
                    <h4>5 Signs You Should See a Doctor</h4>
                    <p>Learn to recognize warning signs</p>
                </a>
                <a href="https://www.cdc.gov/sleep/about_sleep/sleep-hygiene.html" target="_blank" rel="noopener" class="popular-post">
                    <h4>Sleep Hygiene: Better Rest Tonight</h4>
                    <p>Science-backed sleep tips</p>
                </a>
                <a href="https://www.mayoclinic.org/diseases-conditions/laboratory-tests/basics/definition/LAB-20020865" target="_blank" rel="noopener" class="popular-post">
                    <h4>Understanding Your Blood Test Results</h4>
                    <p>A patient's guide to lab work</p>
                </a>
                <a href="https://www.cdc.gov/nutrition/data-statistics/added-sugars.html" target="_blank" rel="noopener" class="popular-post">
                    <h4>Hydration: How Much Water Do You Need?</h4>
                    <p>Separating fact from fiction</p>
                </a>
            </div>

            <div class="sidebar-card">
                <h3>Categories</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="#" style="color: #4b5563; text-decoration: none; padding: 0.5rem; border-radius: 0.25rem; transition: background 0.3s;">
                        <span style="margin-right: 0.5rem;">🛡️</span> Prevention (12)
                    </a>
                    <a href="#" style="color: #4b5563; text-decoration: none; padding: 0.5rem; border-radius: 0.25rem; transition: background 0.3s;">
                        <span style="margin-right: 0.5rem;">🥗</span> Nutrition (18)
                    </a>
                    <a href="#" style="color: #4b5563; text-decoration: none; padding: 0.5rem; border-radius: 0.25rem; transition: background 0.3s;">
                        <span style="margin-right: 0.5rem;">🏃</span> Fitness (15)
                    </a>
                    <a href="#" style="color: #4b5563; text-decoration: none; padding: 0.5rem; border-radius: 0.25rem; transition: background 0.3s;">
                        <span style="margin-right: 0.5rem;">🧠</span> Mental Health (9)
                    </a>
                    <a href="#" style="color: #4b5563; text-decoration: none; padding: 0.5rem; border-radius: 0.25rem; transition: background 0.3s;">
                        <span style="margin-right: 0.5rem;">❄️</span> Seasonal (6)
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
    function filterCategory(element, category) {
        document.querySelectorAll('.category-tag').forEach(tag => {
            tag.classList.remove('active');
        });
        element.classList.add('active');

        const posts = document.querySelectorAll('.blog-card');
        posts.forEach(post => {
            if (category === 'all' || post.dataset.category === category) {
                post.style.display = 'block';
            } else {
                post.style.display = 'none';
            }
        });
    }

    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const posts = document.querySelectorAll('.blog-card');
        
        posts.forEach(post => {
            const title = post.querySelector('h3').textContent.toLowerCase();
            const content = post.querySelector('p').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                post.style.display = 'block';
            } else {
                post.style.display = 'none';
            }
        });
    });
</script>
@endsection
