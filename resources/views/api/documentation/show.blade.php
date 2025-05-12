<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $endpoint->name }} - API Documentation</title>
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
        .method-badge {
            @apply inline-flex items-center px-3 py-1 rounded-full text-xs font-medium;
        }
        .method-badge.get { @apply bg-green-100 text-green-800; }
        .method-badge.post { @apply bg-blue-100 text-blue-800; }
        .method-badge.put { @apply bg-yellow-100 text-yellow-800; }
        .method-badge.delete { @apply bg-red-100 text-red-800; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center space-x-4">
                            <h1 class="text-4xl font-bold tracking-tight">{{ $endpoint->name }}</h1>
                            <span class="method-badge {{ strtolower($endpoint->method->method) }}">
                                {{ $endpoint->method->method }}
                            </span>
                        </div>
                        <p class="mt-2 text-lg text-indigo-100">{{ $endpoint->description }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if($endpoint->group)
                        <a href="{{ route('api.documentation.group', $endpoint->group) }}" 
                           class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-indigo-600 transition-colors duration-200">
                            View Group Collections
                        </a>
                        @endif
                        <a href="{{ url()->previous() }}" 
                           class="inline-flex items-center px-6 py-3 border-2 border-white text-base font-medium rounded-lg text-white hover:bg-white hover:text-indigo-600 transition-colors duration-200">
                            ← Back to List
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow-lg rounded-xl overflow-hidden hover-scale">
                    <!-- Endpoint Info -->
                    <div class="p-8 border-b border-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 mb-6">Endpoint Information</h2>
                                <dl class="space-y-6">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">URI</dt>
                                        <dd class="mt-2 text-sm text-gray-900 font-mono bg-gray-50 p-4 rounded-lg">{{ $endpoint->uri }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Group</dt>
                                        <dd class="mt-2 text-sm text-gray-900">
                                            @if($endpoint->group)
                                            <a href="{{ route('api.documentation.group', $endpoint->group) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                {{ $endpoint->group->name }}
                                            </a>
                                            @else
                                            <span class="text-gray-500">N/A</span>
                                            @endif
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Collection</dt>
                                        <dd class="mt-2 text-sm text-gray-900">{{ $endpoint->collection->name ?? 'N/A' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 mb-6">Description</h2>
                                <div class="prose prose-indigo max-w-none">
                                    <p class="text-gray-600">{{ $endpoint->description ?? 'No description available.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Headers -->
                    @if($endpoint->headers->isNotEmpty())
                    <div class="p-8 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Headers</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Key</th>
                                        <th class="px-8 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Value</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($endpoint->headers as $header)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-8 py-5 whitespace-nowrap text-sm font-medium text-gray-900">{{ $header->key }}</td>
                                        <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $header->value }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Payload -->
                    @if($endpoint->payloads->isNotEmpty())
                    <div class="p-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Request Payload</h2>
                        <div class="bg-gray-800 rounded-lg overflow-hidden">
                            <pre class="p-6"><code class="language-json">{{ json_encode($endpoint->payloads->first()->body, JSON_PRETTY_PRINT) }}</code></pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((el) => {
                hljs.highlightElement(el);
            });
        });
    </script>
</body>
</html> 