@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">Database Setup</h2>

    <div class="mb-4 text-center" id="migration-status">
        <p>We are now setting up your database tables. This may take a moment.</p>
        <div class="progress progress-sm mb-3">
            <div class="progress-bar progress-bar-indeterminate"></div>
        </div>
    </div>

    <div id="migration-result" class="d-none">
        <div class="alert alert-success">Database tables created successfully!</div>
        <div class="form-footer">
            <a href="{{ route('install.admin') }}" class="btn btn-primary w-100">Continue</a>
        </div>
    </div>

    <div id="migration-error" class="d-none">
        <div class="alert alert-danger" id="error-message"></div>
        <div class="form-footer">
            <button onclick="runMigrations()" class="btn btn-primary w-100">Retry</button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function runMigrations() {
        document.getElementById('migration-status').classList.remove('d-none');
        document.getElementById('migration-result').classList.add('d-none');
        document.getElementById('migration-error').classList.add('d-none');

        fetch("{{ route('install.migrations.run') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('migration-status').classList.add('d-none');
            if (data.success) {
                document.getElementById('migration-result').classList.remove('d-none');
            } else {
                document.getElementById('migration-error').classList.remove('d-none');
                document.getElementById('error-message').innerText = data.message;
            }
        })
        .catch(error => {
            document.getElementById('migration-status').classList.add('d-none');
            document.getElementById('migration-error').classList.remove('d-none');
            document.getElementById('error-message').innerText = 'An unexpected error occurred.';
        });
    }

    document.addEventListener('DOMContentLoaded', runMigrations);
</script>
@endpush
