@extends('admin.layout')

@section('page_title', __('Centralized Bookings Data'))

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2 text-primary"></i>{{ __('All Reservations') }}</h5>
        <div>
            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $reservations->count() }} {{ __('Total Bookings') }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">{{ __('Reference') }}</th>
                        <th>{{ __('Customer') }}</th>
                        <th>{{ __('Tenant (Source)') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Payment') }}</th>
                        <th>{{ __('Booking Status') }}</th>
                        <th class="pe-4 text-end">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $reservation->reference_number }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $reservation->customer_name }}</div>
                                <div class="small text-muted">{{ $reservation->customer_email }}</div>
                            </td>
                            <td>
                                <!-- TENANT BADGE -->
                                <span class="badge bg-dark bg-opacity-10 text-dark border border-secondary border-opacity-25 rounded-pill px-3 py-1 shadow-sm">
                                    <i class="bi bi-shop me-1 text-primary"></i> {{ $reservation->website->domain ?? 'Unknown' }}
                                </span>
                            </td>
                            <td class="fw-bold">${{ number_format($reservation->total_amount, 2) }}</td>
                            <td>
                                @if($reservation->payment_status === 'paid')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1"><i class="bi bi-check-circle me-1"></i> Paid</span>
                                @elseif($reservation->payment_status === 'pending')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1"><i class="bi bi-clock me-1"></i> Pending</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2 py-1">{{ ucfirst($reservation->payment_status) }}</span>
                                @endif
                                <div class="small text-muted mt-1" style="font-size: 0.65rem;" title="Stripe Intent ID">{{ Str::limit($reservation->stripe_payment_intent_id, 10) }}</div>
                            </td>
                            <td>
                                @if($reservation->status === 'confirmed')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-1">Confirmed</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-2 py-1">{{ ucfirst($reservation->status) }}</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end text-muted small">
                                {{ $reservation->created_at->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 text-light"></i>
                                {{ __('No reservations found across any tenants.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
