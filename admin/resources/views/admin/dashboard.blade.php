<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
        <p>Welcome to the admin panel. Use the navigation to manage the website.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Total Users</h2>
                <p class="text-3xl">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Total Super Admins</h2>
                <p class="text-3xl">{{ $totalSuperAdmins ?? 0 }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-2">Total Contents</h2>
                <p class="text-3xl">{{ $totalContents ?? 0 }}</p>
            </div>
        </div>

        <a href="{{ route('admin.users') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Manage Users</a>

        <a href="{{ route('admin.adminContents') }}" class="mt-4 ml-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Manage Admin Contents</a>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Contents List</h2>
            @if($contents->count() > 0)
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">Title</th>
                            <th class="py-2 px-4 border-b">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $content)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $content->title }}</td>
                                <td class="py-2 px-4 border-b">{{ $content->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $contents->links() }}
                </div>
            @else
                <p>No contents found.</p>
            @endif
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Admin Contents List</h2>
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
    </div>
</x-app-layout>
