<x-filament::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="text-lg font-medium text-gray-900">Page Information</h2>
            <dl class="mt-4 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Template</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $this->record->template->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $this->record->title }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $this->record->slug }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->record->is_published ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $this->record->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </dd>
                </div>
                @if($this->record->published_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Published At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $this->record->published_at->format('F j, Y g:i A') }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        @if($this->record->content)
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="text-lg font-medium text-gray-900">Content</h2>
                <div class="mt-4 prose max-w-none">
                    {!! $this->record->content !!}
                </div>
            </div>
        @endif

        @if($this->record->data)
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="text-lg font-medium text-gray-900">Dynamic Fields</h2>
                <dl class="mt-4 space-y-4">
                    @foreach($this->record->data as $key => $value)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ Str::title(str_replace('_', ' ', $key)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if(is_array($value))
                                    <pre class="whitespace-pre-wrap">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                @elseif(Str::startsWith($value, 'http'))
                                    <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ $value }}</a>
                                @else
                                    {{ $value }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        @endif
    </div>
</x-filament::page> 