@extends('layouts.installer')

@section('content')
    <div class="text-center">
        <div class="mb-3 text-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
        </div>
        <h2 class="card-title">Installation Complete!</h2>
        <p class="text-secondary">Nexus CMS has been successfully installed.</p>
    </div>

    <div class="alert alert-important alert-warning mb-4">
        <strong>Security Note:</strong> The installer has been locked. To re-install, you must delete <code>storage/installed.lock</code>.
    </div>

    <div class="form-footer">
        <a href="{{ url('/admin') }}" class="btn btn-primary w-100">
            Go to Admin Dashboard
        </a>
    </div>
@endsection
