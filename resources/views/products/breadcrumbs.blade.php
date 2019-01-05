@if (isset($categories))
    <div class="breadcrumbs">
        @if ($categories['level_1'] == 'search')
            <strong>Search</strong> <i class="fas fa-caret-right mx-2"></i> {{ $categories['query'] }}
        @else
            {{ $categories['level_1'] ? $categories['level_1'] : '' }}
            {!! $categories['level_2'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_2'] : '' !!}
            {!! $categories['level_3'] ? ' <i class="fas fa-caret-right mx-2"></i> ' . $categories['level_3'] : '' !!}
        @endif
    </div>
@endif