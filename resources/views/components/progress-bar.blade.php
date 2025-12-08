@props(['current', 'total'])
<div class="progress">
    <div class="progress-bar" style="width: {{ ($current/$total)*100 }}%">
        Step {{ $current }} of {{ $total }}
    </div>
</div>
