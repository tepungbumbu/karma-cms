@extends('layouts.installer')

@section('content')
    <div class="text-center mb-4">
        <h2 class="card-title">Welcome to Nexus CMS</h2>
        <p class="text-secondary">Let's get your professional website started.</p>
    </div>

    <div class="mb-4">
        <p>This installer will guide you through the process of setting up Nexus CMS on your shared hosting environment. We'll check your server requirements, configure your database, and set up your administrator account.</p>
    </div>

    <div class="form-footer">
        <a href="{{ route('install.requirements') }}" class="btn btn-primary w-100">
            Start Installation
        </a>
    </div>
@endsection
