<!DOCTYPE html>
<html>
<head>
    <title>Edit File - {{ $filename }}</title>
</head>
<body>
    <h1>Edit File: {{ $filename }}</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('filemanager.update', ['filename' => $filename]) }}" method="POST">
        @csrf
        @method('PUT')
        <textarea name="content" rows="20" cols="80">{{ old('content', $content) }}</textarea><br>
        <button type="submit">Save</button>
    </form>

    <a href="{{ route('filemanager.show', ['filename' => $filename]) }}">Cancel</a>
</body>
</html>
