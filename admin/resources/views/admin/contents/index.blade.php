<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Admin Contents</h1>

        <a href="{{ route('admin.adminContents.create') }}" class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create New Content</a>

        @if($adminContents->count() > 0)
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Title</th>
                        <th class="py-2 px-4 border-b">Created At</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($adminContents as $adminContent)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $adminContent->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $adminContent->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('admin.adminContents.edit', $adminContent->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.adminContents.delete', $adminContent->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this content?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $adminContents->links() }}
            </div>
        @else
            <p>No admin contents found.</p>
        @endif
    </div>
</x-app-layout>
