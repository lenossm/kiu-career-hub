@if (session('success'))
    <div class="alert alert-success kiu-alert kiu-card anim-fade-up mb-3" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger kiu-alert kiu-card anim-fade-up mb-3" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger kiu-alert kiu-card anim-fade-up mb-3" role="alert">
        <div class="fw-semibold mb-2"><i class="bi bi-exclamation-circle me-1"></i> Please fix the following:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
