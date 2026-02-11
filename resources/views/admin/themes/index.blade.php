@extends('layouts.admin')

@section('title', 'Themes')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Themes</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            @foreach($themes as $theme)
            <div class="col-sm-6 col-lg-4">
                <div class="card card-sm">
                    <img src="{{ $theme['screenshot'] ?: 'https://via.placeholder.com/800x450?text=' . $theme['name'] }}" class="card-img-top" alt="{{ $theme['name'] }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <div>{{ $theme['name'] }}</div>
                                <div class="text-secondary">v{{ $theme['version'] }} by {{ $theme['author'] }}</div>
                            </div>
                            <div class="ms-auto">
                                @if($activeTheme && $activeTheme->slug === $theme['slug'])
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <form action="{{ route('admin.themes.activate') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="slug" value="{{ $theme['slug'] }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Activate</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
