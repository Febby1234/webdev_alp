@props(['type' => 'info'])

@php
$configs = [
    'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-400', 'text' => 'text-green-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-400', 'text' => 'text-red-700', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
    'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-400', 'text' => 'text-yellow-700', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
    'info' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-400', 'text' => 'text-blue-700', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
];
$config = $configs[$type] ?? $configs['info'];
@endphp

<div class="{{ $config['bg'] }} border-l-4 {{ $config['border'] }} p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 {{ $config['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm {{ $config['text'] }}">{{ $slot }}</p>
        </div>
    </div>
</div>
