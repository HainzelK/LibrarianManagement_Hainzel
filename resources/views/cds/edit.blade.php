<!-- resources/views/cds/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit CD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="my-4">Edit CD</h1>

    <form action="{{ route('cds.update', $cd->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $cd->title }}" required>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ $cd->author }}" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ $cd->category }}" required>
        </div>

        <div class="mb-3">
            <label for="publication_date" class="form-label">Publication Date</label>
            <input type="date" class="form-control" id="publication_date" name="publication_date" value="{{ $cd->publication_date }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $cd->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="is_accessible" class="form-label">Access Status</label>
            <select class="form-control" id="is_accessible" name="is_accessible" required>
                <option value="requested" {{ $cd->is_accessible == 'requested' ? 'selected' : '' }}>Requested</option>
                <option value="granted" {{ $cd->is_accessible == 'granted' ? 'selected' : '' }}>Granted</option>
                <option value="denied" {{ $cd->is_accessible == 'denied' ? 'selected' : '' }}>Denied</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update CD</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
