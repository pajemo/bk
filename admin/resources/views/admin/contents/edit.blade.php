@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Content</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contents.update', $content->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $content->title) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="slug">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $content->slug) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                <option value="page" {{ old('type', $content->type) == 'page' ? 'selected' : '' }}>Page</option>
                <option value="post" {{ old('type', $content->type) == 'post' ? 'selected' : '' }}>Post</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="body">Body</label>
            <textarea name="body" class="form-control" rows="5">{{ old('body', $content->body) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_published" class="form-check-input" id="is_published" {{ old('is_published', $content->is_published) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('contents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
