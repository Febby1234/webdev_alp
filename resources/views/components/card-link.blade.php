@props(['href', 'icon', 'title', 'subtitle' => null, 'badge' => null])

<a href="{{ $href }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-md transition-all duration-200 block">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
            </svg>
        </div>
        <div class="ml-4 flex-1">
            <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            @if($subtitle)
                <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
            @endif
            @if($badge)
                <div class="mt-2">
                    <x-status-badge :status="$badge" />
                </div>
            @endif
        </div>
    </div>
</a>
