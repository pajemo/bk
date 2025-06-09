<!DOCTYPE html>
<html>
<head>
    <title>File Manager - Admin</title>
</head>
<body>
    <h1>File Manager</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('filemanager.create') }}">Create New File</a>

    <ul>
        @foreach($files as $file)
            <li>
                {{ $file }}
                <a href="{{ route('filemanager.show', ['filename' => $file]) }}">View</a>
                <a href="{{ route('filemanager.edit', ['filename' => $file]) }}">Edit</a>
                <form action="{{ route('filemanager.destroy', ['filename' => $file]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this file?');">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
