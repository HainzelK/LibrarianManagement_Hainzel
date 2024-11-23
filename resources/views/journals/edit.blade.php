<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Journal - Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('journals.update', $journal->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $journal->title) }}" placeholder="Enter Journal Title">
                                
                                @error('title')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Author</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $journal->author) }}" placeholder="Enter Author Name">
                                
                                @error('author')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Category</label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category', $journal->category) }}" placeholder="Enter Category">
                                
                                @error('category')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Publication Date</label>
                                <input type="date" class="form-control @error('publication_date') is-invalid @enderror" name="publication_date" value="{{ old('publication_date', $journal->publication_date) }}">
                                
                                @error('publication_date')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Enter Journal Description">{{ old('description', $journal->description) }}</textarea>
                                
                                @error('description')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Access Status</label>
                                <select class="form-control @error('is_accessible') is-invalid @enderror" name="is_accessible">
                                    <option value="requested" {{ old('is_accessible', $journal->is_accessible) == 'requested' ? 'selected' : '' }}>Requested</option>
                                    <option value="granted" {{ old('is_accessible', $journal->is_accessible) == 'granted' ? 'selected' : '' }}>Granted</option>
                                    <option value="denied" {{ old('is_accessible', $journal->is_accessible) == 'denied' ? 'selected' : '' }}>Denied</option>
                                </select>
                                
                                @error('is_accessible')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">Update</button>
                            <a href="{{ route('journals.index') }}" class="btn btn-md btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
