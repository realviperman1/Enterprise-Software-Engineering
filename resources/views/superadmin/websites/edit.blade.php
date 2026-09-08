<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperAdmin - Global Translations Editor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Edit Tenant: {{ $website->domain }}</h2>
            <a href="#" class="btn btn-outline-secondary">Back to Dashboard</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="#" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Spatie Translation Tabs Navigation -->
                    <ul class="nav nav-tabs mb-4" id="languageTabs" role="tablist">
                        @foreach($languages as $index => $language)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                                        id="tab-{{ $language->code }}" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#pane-{{ $language->code }}" 
                                        type="button" role="tab">
                                    {{ $language->name }} ({{ strtoupper($language->code) }})
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Translation Tab Panes -->
                    <div class="tab-content" id="languageTabsContent">
                        @foreach($languages as $index => $language)
                            @php $code = $language->code; @endphp
                            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                                 id="pane-{{ $code }}" 
                                 role="tabpanel">
                                
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Website Name ({{ $code }})</label>
                                    <input type="text" name="name[{{ $code }}]" 
                                           class="form-control" 
                                           value="{{ $website->getTranslation('name', $code, false) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">SEO Title ({{ $code }})</label>
                                    <input type="text" name="seo_title[{{ $code }}]" 
                                           class="form-control" 
                                           value="{{ $website->getTranslation('seo_title', $code, false) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Description ({{ $code }})</label>
                                    <textarea name="description[{{ $code }}]" class="form-control" rows="4">{{ $website->getTranslation('description', $code, false) }}</textarea>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary px-5">Save Translations</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
