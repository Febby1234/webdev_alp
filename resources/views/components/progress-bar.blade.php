@props(['current', 'total'])

@php
$percentage = round(($current / $total) * 100);
@endphp

<div class="w-full">
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
             style="width: {{ $percentage }}%">
        </div>
    </div>
    <p class="text-sm text-gray-600 mt-2 text-center">
        Langkah {{ $current }} dari {{ $total }} ({{ $percentage }}%)
    </p>
</div>
