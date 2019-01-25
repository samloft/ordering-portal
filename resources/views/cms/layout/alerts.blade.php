@if (session('error') || $errors->any())
    <div class="alert alert-soft-danger d-flex align-items-center" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <div class="text-body"><strong>Error - </strong> {{ session('error') ? session('error') : $errors->first() }}</div>
    </div>
@endif