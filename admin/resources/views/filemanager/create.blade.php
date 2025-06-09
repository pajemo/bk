<!DOCTYPE html>
<html>
<head>
    <title>Create New File</title>
</head>
<body>
    <h1>Create New File</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('filemanager.store') }}" method="POST">
        @csrf
        <label for="filename">Filename:</label><br>
        <input type="text" id="filename" name="filename" value="{{ old('filename') }}"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="20" cols="80">{{ old('content') }}</textarea><br><br>

        <button type="submit">Create</button>
    </form>

    <a href="{{ route('filemanager.index') }}">Back to List</a>
</body>
</html>
