<div class="breadcrumbs">
    {{ $categories['level_1'] ? $categories['level_1'] : '' }}
    {!! $categories['level_2'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_2'] : '' !!}
    {!! $categories['level_3'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_3'] : '' !!}
</div>