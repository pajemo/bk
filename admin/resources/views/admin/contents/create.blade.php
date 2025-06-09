@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Content</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contents.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="slug">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                <option value="page" {{ old('type') == 'page' ? 'selected' : '' }}>Page</option>
                <option value="post" {{ old('type') == 'post' ? 'selected' : '' }}>Post</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="body">Body</label>
            <textarea name="body" class="form-control" rows="5">{{ old('body') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_published" class="form-check-input" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('contents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
