@if (session('error') || $errors->any())
    <div class="alert alert-soft-danger d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <div class="text-body"><strong>Error - </strong> {{ session('error') ? session('error') : $errors->first() }}</div>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-soft-success d-flex align-items-center" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <div class="text-body"><strong>Success - </strong> {{ session('success') }}</div>
    </div>
@endif