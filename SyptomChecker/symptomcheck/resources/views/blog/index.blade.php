@extends('layouts.app')

@section('title', 'Blog - SymptomChecker')

@section('content')
<div class="container">
    <section class="hero" style="padding: 3rem 2rem;">
        <h1>Blog & Articles</h1>
        <p class="text-muted">We are building our blog — content coming soon. Check back later for health articles and guides.</p>
    </section>

    <div style="max-width:900px; margin: 2rem auto; text-align:center;">
        <div class="dashboard-card">
            <h3>Coming Soon</h3>
            <p>We will publish health guides, condition explainers, and treatment resources here.</p>
            <p class="text-muted">In the meantime, start an assessment to get immediate guidance.</p>
            <a href="{{ route('start') }}" class="btn btn-primary btn-large">Start Assessment</a>
        </div>
    </div>
</div>
@endsection
