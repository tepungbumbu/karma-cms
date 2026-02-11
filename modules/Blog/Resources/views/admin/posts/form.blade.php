@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Post' : 'Create Post')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">{{ $post->exists ? 'Edit Post' : 'Create Post' }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="{{ $post->exists ? route('admin.blog.posts.update', $post) : route('admin.blog.posts.store') }}" method="POST">
            @csrf
            @if($post->exists) @method('PUT') @endif

            <div class="row row-cards">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" placeholder="Post title">
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Content</label>
                                <textarea name="content" class="form-control" rows="12">{{ old('content', $post->content) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select name="status" class="form-select">
                                    <option value="draft" @selected(old('status', $post->status) == 'draft')>Draft</option>
                                    <option value="published" @selected(old('status', $post->status) == 'published')>Published</option>
                                    <option value="scheduled" @selected(old('status', $post->status) == 'scheduled')>Scheduled</option>
                                    <option value="archived" @selected(old('status', $post->status) == 'archived')>Archived</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Category</label>
                                <select name="category_id" class="form-select">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $post->is_featured))>
                                    <span class="form-check-label">Featured Post</span>
                                </label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Published At</label>
                                <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
