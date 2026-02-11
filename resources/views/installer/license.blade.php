@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">License Verification</h2>

    <form action="{{ route('install.license.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Envato Purchase Code</label>
            <input type="text" name="purchase_code" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx" required>
            <small class="form-hint">Enter your CodeCanyon purchase code to verify your license.</small>
        </div>

        @if($errors->has('error'))
            <div class="alert alert-danger">{{ $errors->first('error') }}</div>
        @endif

        <div class="form-footer">
            <div class="row">
                <div class="col"><a href="{{ route('install.requirements') }}" class="btn btn-link w-100">Back</a></div>
                <div class="col"><button type="submit" class="btn btn-primary w-100">Verify & Next</button></div>
            </div>
        </div>
    </form>
@endsection
