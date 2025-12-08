@props(['href', 'text' => 'Kembali'])

<div class="mb-6">
    <a href="{{ $href }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        {{ $text }}
    </a>
</div>
