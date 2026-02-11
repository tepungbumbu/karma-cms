@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">Select Core Modules</h2>
    <p class="text-secondary text-center">Choose the initial modules to activate.</p>

    <form action="{{ route('install.modules.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            @forelse($modules as $slug => $module)
                <label class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="modules[]" value="{{ $slug }}" {{ ($module['is_core'] ?? false) ? 'checked onclick="return false;"' : '' }}>
                    <span class="form-check-label">
                        <strong>{{ $module['name'] }}</strong> <small class="text-secondary">v{{ $module['version'] }}</small>
                        <div class="text-secondary small">{{ $module['description'] ?? '' }}</div>
                    </span>
                </label>
            @empty
                <div class="alert alert-info py-2">No optional modules found. You can install them later from the dashboard.</div>
            @endforelse
        </div>

        <div class="form-footer text-center">
            <button type="submit" class="btn btn-primary w-100">Finish Installation</button>
        </div>
    </form>
@endsection
