@if (session('success'))
<div class="alert alert-important alert-success alert-dismissible" role="alert">
    <div class="d-flex">
        <div class="me-2">
            <i class="fas fa-check"></i>
        </div>
        <div>
            {{ session('success') }}
        </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
@endif

@if (session('error'))
<div class="alert alert-important alert-danger alert-dismissible" role="alert">
    <div class="d-flex">
        <div class="me-2">
            <i class="fas fa-times"></i>
        </div>
        <div>
            {{ session('error') }}
        </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
@endif

@if (session('warning'))
<div class="alert alert-important alert-warning alert-dismissible" role="alert">
    <div class="d-flex">
        <div class="me-2">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div>
            {{ session('warning') }}
        </div>
    </div>
    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
</div>
@endif