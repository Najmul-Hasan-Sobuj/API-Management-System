<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->name }} - Collections</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/json.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold tracking-tight">{{ $group->name }}</h1>
                        <p class="mt-2 text-lg text-indigo-100">{{ $group->description }}</p>
                    </div>
                    <a href="{{ url()->previous() }}" class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-indigo-600 transition-colors duration-200">
                        ← Back to List
                    </a>
                </div>
            </div>
        </header>

        <!-- Stats -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-indigo-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-indigo-600">{{ $group->collections->count() }}</div>
                        <div class="text-sm text-indigo-600 font-medium">Collections</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-purple-600">{{ $group->collections->sum(function($collection) { return $collection->endpoints->count(); }) }}</div>
                        <div class="text-sm text-purple-600 font-medium">Total Endpoints</div>
                    </div>
                    <div class="bg-pink-50 rounded-lg p-6">
                        <div class="text-3xl font-bold text-pink-600">{{ $group->collections->filter(function($collection) { return $collection->endpoints->isNotEmpty(); })->count() }}</div>
                        <div class="text-sm text-pink-600 font-medium">Active Collections</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                @foreach($group->collections as $collection)
                <div class="bg-white shadow-lg rounded-xl mb-8 overflow-hidden hover-scale">
                    <div class="p-8 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $collection->name }}</h2>
                                <p class="mt-2 text-gray-600">{{ $collection->description }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $collection->endpoints->count() }} Endpoints
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($collection->endpoints->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">URI</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($collection->endpoints as $endpoint)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $endpoint->name }}</div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 font-mono">{{ $endpoint->uri }}</div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($endpoint->method->method === 'GET') bg-green-100 text-green-800
                                            @elseif($endpoint->method->method === 'POST') bg-blue-100 text-blue-800
                                            @elseif($endpoint->method->method === 'PUT') bg-yellow-100 text-yellow-800
                                            @elseif($endpoint->method->method === 'DELETE') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $endpoint->method->method }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-sm">
                                        <a href="{{ route('api.documentation.show', $endpoint) }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                            View Documentation
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-8 text-center">
                        <div class="text-gray-500">No endpoints found in this collection.</div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html> 