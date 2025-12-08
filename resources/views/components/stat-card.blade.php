@props(['title', 'value', 'icon', 'color' => 'blue'])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-{{ $color }}-100 rounded-lg p-3">
                <svg class="w-8 h-8 text-{{ $color }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">{{ $title }}</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ $value }}</h3>
            </div>
        </div>
    </div>
</div>
