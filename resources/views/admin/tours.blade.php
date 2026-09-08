@extends('admin.layout')

@section('page_title', __('Tour Master Catalog (CMS)'))

@section('content')
<div class="row g-4">
    <!-- List of Master Tours -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-collection me-2 text-primary"></i>{{ __('Centralized Tours') }}</h5>
                <button type="button" class="btn btn-primary btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#tourModal" onclick="resetForm()">
                    <i class="bi bi-plus-lg me-1"></i> {{ __('Create New Master Tour') }}
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">{{ __('ID') }}</th>
                                <th>{{ __('Tour Name') }}</th>
                                <th>{{ __('Base Price') }}</th>
                                <th>{{ __('Tenant / Scope') }}</th>
                                <th>{{ __('Overrides') }}</th>
                                <th class="pe-4 text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tours->whereNull('parent_tour_id') as $masterTour)
                                <!-- Master Row -->
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#{{ $masterTour->id }}</td>
                                    <td class="fw-bold">{{ $masterTour->getTranslation('name', 'en') }}</td>
                                    <td>${{ number_format($masterTour->base_price, 2) }}</td>
                                    <td>
                                        @if($masterTour->website_id)
                                            <span class="badge bg-info text-dark border border-info rounded-pill px-3">{{ $masterTour->website->domain }}</span>
                                        @else
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3"><i class="bi bi-globe me-1"></i> Global Master</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary rounded-pill">{{ $masterTour->overrides->count() }} overrides</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-sm btn-outline-primary fw-bold" onclick="editTour({{ $masterTour }})">{{ __('Edit Master') }}</button>
                                        <button class="btn btn-sm btn-outline-secondary fw-bold ms-1" onclick="createOverride({{ $masterTour }})">{{ __('Add Override') }}</button>
                                    </td>
                                </tr>
                                
                                <!-- Overrides Rows -->
                                @foreach($masterTour->overrides as $override)
                                    <tr class="table-light">
                                        <td class="ps-4 text-muted"><i class="bi bi-arrow-return-right ms-2"></i> #{{ $override->id }}</td>
                                        <td class="text-muted fst-italic">{{ $override->getTranslation('name', 'en') }}</td>
                                        <td class="text-muted fst-italic">${{ number_format($override->base_price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3"><i class="bi bi-shop me-1"></i> {{ $override->website->domain ?? 'Unknown' }}</span>
                                        </td>
                                        <td>-</td>
                                        <td class="pe-4 text-end">
                                            <button class="btn btn-sm btn-outline-secondary fw-bold" onclick="editTour({{ $override }})">{{ __('Edit Override') }}</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">{{ __('No tours found in the centralized database.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tour CMS Modal -->
<div class="modal fade" id="tourModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content shadow border-0" action="{{ route('admin.tours.save') }}" method="POST">
            @csrf
            <div class="modal-header bg-light border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" id="modalTitle">{{ __('Create Master Tour') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body px-4 py-4">
                <input type="hidden" name="tour_id" id="tour_id" value="0">
                <input type="hidden" name="parent_tour_id" id="parent_tour_id" value="">
                
                <div id="override-alert" class="alert alert-info border-info border-opacity-50 shadow-sm d-none mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>{{ __('Override Mode Active:') }}</strong> <span id="override-text"></span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small text-uppercase">{{ __('Name (EN)') }}</label>
                        <input type="text" class="form-control" name="name_en" id="name_en" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small text-uppercase">{{ __('Name (FR)') }}</label>
                        <input type="text" class="form-control" name="name_fr" id="name_fr" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small text-uppercase">{{ __('Base Price (USD)') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">$</span>
                            <input type="number" step="0.01" class="form-control" name="base_price" id="base_price" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted small text-uppercase">{{ __('Assign to Tenant') }}</label>
                        <select class="form-select" name="website_id" id="website_id">
                            <option value="">-- Global Master (All Sites) --</option>
                            @foreach($websites as $website)
                                <option value="{{ $website->id }}">{{ $website->domain }} ({{ $website->name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-muted small text-uppercase">{{ __('Description (EN)') }}</label>
                        <textarea class="form-control" name="description_en" id="description_en" rows="3" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold text-muted small text-uppercase">{{ __('Description (FR)') }}</label>
                        <textarea class="form-control" name="description_fr" id="description_fr" rows="3" required></textarea>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light border-top-0 pb-4 px-4">
                <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" id="saveBtn">{{ __('Save Master Tour') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    const tourModal = new bootstrap.Modal(document.getElementById('tourModal'));
    
    function resetForm() {
        document.getElementById('modalTitle').textContent = '{{ __('Create Master Tour') }}';
        document.getElementById('tour_id').value = '0';
        document.getElementById('parent_tour_id').value = '';
        document.getElementById('website_id').value = '';
        document.getElementById('website_id').disabled = false;
        
        document.getElementById('name_en').value = '';
        document.getElementById('name_fr').value = '';
        document.getElementById('description_en').value = '';
        document.getElementById('description_fr').value = '';
        document.getElementById('base_price').value = '';
        
        document.getElementById('override-alert').classList.add('d-none');
        document.getElementById('saveBtn').textContent = '{{ __('Save Master Tour') }}';
    }

    function editTour(tour) {
        resetForm();
        
        document.getElementById('modalTitle').textContent = tour.parent_tour_id ? '{{ __('Edit Override') }}' : '{{ __('Edit Master Tour') }}';
        document.getElementById('tour_id').value = tour.id;
        document.getElementById('parent_tour_id').value = tour.parent_tour_id || '';
        document.getElementById('website_id').value = tour.website_id || '';
        
        document.getElementById('name_en').value = tour.name.en || '';
        document.getElementById('name_fr').value = tour.name.fr || '';
        document.getElementById('description_en').value = tour.description.en || '';
        document.getElementById('description_fr').value = tour.description.fr || '';
        document.getElementById('base_price').value = tour.base_price;
        
        if(tour.parent_tour_id) {
            document.getElementById('override-alert').classList.remove('d-none');
            document.getElementById('override-text').textContent = '{{ __('You are modifying a tenant-specific override. These changes will not affect other websites.') }}';
            document.getElementById('saveBtn').textContent = '{{ __('Save Override') }}';
        } else {
            document.getElementById('saveBtn').textContent = '{{ __('Update Master Tour') }}';
        }
        
        tourModal.show();
    }

    function createOverride(parentTour) {
        resetForm();
        document.getElementById('modalTitle').textContent = '{{ __('Create Tenant Override') }}';
        document.getElementById('parent_tour_id').value = parentTour.id;
        
        // Pre-fill with parent data as a starting point
        document.getElementById('name_en').value = parentTour.name.en || '';
        document.getElementById('name_fr').value = parentTour.name.fr || '';
        document.getElementById('description_en').value = parentTour.description.en || '';
        document.getElementById('description_fr').value = parentTour.description.fr || '';
        document.getElementById('base_price').value = parentTour.base_price;
        
        document.getElementById('override-alert').classList.remove('d-none');
        document.getElementById('override-text').textContent = '{{ __('Creating an override for: ') }}' + parentTour.name.en + '{{ __('. Select a tenant below.') }}';
        document.getElementById('saveBtn').textContent = '{{ __('Save Override') }}';
        
        tourModal.show();
    }
</script>
@endsection
