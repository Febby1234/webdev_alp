@props(['title', 'buttonText' => null, 'buttonHref' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $title }}</h2>

    @if($buttonHref)
        <a href="{{ $buttonHref }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            {{ $buttonText ?? '+ Tambah' }}
        </a>
    @endif

    {{ $slot }}
</div>
