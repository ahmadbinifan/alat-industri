<div class="flex items-center">
    {{ $columnName }}
    @if ($sortColumn !== $columnName)
        <x-heroicon-o-chevron-up-down style="width: 14px;height:14px" />
    @elseif ($sortDirection === 'ASC')
        <x-heroicon-o-chevron-down style="width: 14px;height:14px" />
    @else
        <x-heroicon-o-chevron-up style="width: 14px;height:14px" />
    @endif
</div>
