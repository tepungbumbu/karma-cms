@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Dashboard</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        Welcome to Karma CMS Dashboard.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
