@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">Create Admin Account</h2>

    <form action="{{ route('install.admin.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Admin Name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Create Account & Next</button>
        </div>
    </form>
@endsection
