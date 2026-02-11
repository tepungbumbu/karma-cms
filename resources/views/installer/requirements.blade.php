@extends('layouts.installer')

@section('content')
    <h2 class="card-title text-center mb-4">System Requirements</h2>

    <div class="mb-4">
        <div class="subheader mb-2">PHP Version</div>
        <div class="d-flex align-items-center mb-1">
            <div class="me-2 text-{{ $requirements['php']['satisfied'] ? 'success' : 'danger' }}">
                @if($requirements['php']['satisfied'])
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                @endif
            </div>
            <div>PHP {{ $requirements['php']['value'] }} (Required: 8.2+)</div>
        </div>

        <div class="subheader mb-2 mt-4">PHP Extensions</div>
        @foreach($requirements['extensions'] as $ext => $satisfied)
            <div class="d-flex align-items-center mb-1">
                <div class="me-2 text-{{ $satisfied ? 'success' : 'danger' }}">
                    @if($satisfied)
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                    @endif
                </div>
                <div>{{ $ext }}</div>
            </div>
        @endforeach

        <div class="subheader mb-2 mt-4">Permissions</div>
        @foreach($requirements['permissions'] as $path => $satisfied)
            <div class="d-flex align-items-center mb-1">
                <div class="me-2 text-{{ $satisfied ? 'success' : 'danger' }}">
                    @if($satisfied)
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                    @endif
                </div>
                <div>{{ $path }} directory is writable</div>
            </div>
        @endforeach
    </div>

    <div class="form-footer">
        <div class="row">
            <div class="col"><a href="{{ route('install.welcome') }}" class="btn btn-link w-100">Back</a></div>
            <div class="col"><a href="{{ route('install.license') }}" class="btn btn-primary w-100">Next</a></div>
        </div>
    </div>
@endsection
