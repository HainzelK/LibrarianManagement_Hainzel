<!-- resources/views/newspapers/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Newspaper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h4 class="mb-4">Add New Newspaper</h4>
                    <form action="{{ route('newspapers.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title" class="font-weight-bold">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="publisher" class="font-weight-bold">Publisher</label>
                            <select class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" required>
                                <option value="">Select Publisher</option>
                                <option value="Kompas" {{ old('publisher') == 'Kompas' ? 'selected' : '' }}>Kompas</option>
                                <option value="Tribun Timur" {{ old('publisher') == 'Tribun Timur' ? 'selected' : '' }}>Tribun Timur</option>
                                <option value="Fajar" {{ old('publisher') == 'Fajar' ? 'selected' : '' }}>Fajar</option>
                            </select>
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="publication_date" class="font-weight-bold">Publication Date</label>
                            <input type="date" class="form-control @error('publication_date') is-invalid @enderror" id="publication_date" name="publication_date" value="{{ old('publication_date') }}" required>
                            @error('publication_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="font-weight-bold">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="stored" {{ old('status') == 'stored' ? 'selected' : '' }}>Stored</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('newspapers.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
