<x-filament::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="text-lg font-medium text-gray-900">Template Information</h2>
            <dl class="mt-4 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $this->record->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Slug</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $this->record->slug }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $this->record->description }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->record->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $this->record->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="text-lg font-medium text-gray-900">Template Fields</h2>
            <div class="mt-4 space-y-4">
                @foreach($this->record->fields as $field)
                    <div class="p-4 border rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $field['label'] }}</h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $field['name'] }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($field['type']) }}
                            </span>
                        </div>
                        <div class="mt-2 space-y-2">
                            @if($field['required'] ?? false)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Required
                                </span>
                            @endif
                            @if($field['unique'] ?? false)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Unique
                                </span>
                            @endif
                            @if($field['help_text'] ?? false)
                                <p class="text-sm text-gray-500">{{ $field['help_text'] }}</p>
                            @endif
                            @if(in_array($field['type'], ['select', 'checkbox', 'radio']) && ($field['options'] ?? false))
                                <div class="mt-2">
                                    <p class="text-sm font-medium text-gray-500">Options:</p>
                                    <ul class="mt-1 text-sm text-gray-900 list-disc list-inside">
                                        @foreach(explode(',', $field['options']) as $option)
                                            <li>{{ trim($option) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-filament::page> 