<div class="row mb-3">
    <div class="col">
        <h1 class="page-title">{{ $progress_title }}</h1>
    </div>
    <div class="col text-right mr-3">
        <div class="row no-gutters mb-2">
            <div class="col"></div>
            <div class="col text-center">{{ __('Basket') }}</div>
            <div class="col text-center">{{ __('Checkout') }}</div>
            <div class="col text-center">{{ __('Confirmation') }}</div>
        </div>
        <div class="row no-gutter">
            <div class="col">{{ __('Order Progress') }}</div>
            <div class="col {{ $progress_amount >= 1 ? 'progress-full' : 'progress-empty' }}"></div>
            <div class="col {{ $progress_amount >= 2 ? 'progress-full' : 'progress-empty' }}"></div>
            <div class="col {{ $progress_amount >= 3 ? 'progress-full' : 'progress-empty' }}"></div>
        </div>
    </div>
</div>