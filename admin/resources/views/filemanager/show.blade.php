<!DOCTYPE html>
<html>
<head>
    <title>View File - {{ $filename }}</title>
</head>
<body>
    <h1>View File: {{ $filename }}</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <pre style="background-color: #f4f4f4; padding: 10px; border: 1px solid #ccc;">{{ $content }}</pre>

    <a href="{{ route('filemanager.edit', ['filename' => $filename]) }}">Edit</a> |
    <a href="{{ route('filemanager.index') }}">Back to List</a>
</body>
</html>
