<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperAdmin - Global Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4 px-5">
        <h2 class="fw-bold mb-4 text-primary">SuperAdmin Global Dashboard</h2>
        
        <div class="row">
            <!-- Tenants Panel -->
            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white fw-bold">
                        Managed Tenants (Websites)
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($websites as $website)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <strong class="d-block text-dark">{{ $website->domain }}</strong>
                                    <small class="text-muted">Reservations: {{ $website->reservations_count }}</small>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Edit Translations</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Global Activity Panel -->
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-danger text-white fw-bold">
                        Global Activity (Cross-Tenant Scope Bypassed)
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ref</th>
                                    <th>Tenant Source</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($globalReservations as $res)
                                    <tr>
                                        <td class="fw-semibold text-muted">{{ $res->reference_number }}</td>
                                        <td><span class="badge bg-secondary">{{ $res->website->domain }}</span></td>
                                        <td>{{ $res->customer_name }}</td>
                                        <td>${{ number_format($res->total_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center py-4">No global activity.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
