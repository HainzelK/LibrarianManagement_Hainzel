<!-- resources/views/newspapers/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newspapers List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-4">Newspapers List</h4>
                        <a href="{{ route('newspapers.create') }}" class="btn btn-success">Add New Newspaper</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Publisher</th>
                                <th>Publication Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($newspapers as $newspaper)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $newspaper->title }}</td>
                                    <td>{{ $newspaper->publisher }}</td>
                                    <td>{{ $newspaper->publication_date }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($newspaper->status == 'available') badge-success 
                                            @elseif($newspaper->status == 'stored') badge-warning 
                                            @endif">
                                            {{ ucfirst($newspaper->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('newspapers.edit', $newspaper->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form onsubmit="return confirm('Are you sure you want to delete this newspaper?');" class="d-inline" action="{{ route('newspapers.destroy', $newspaper->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $newspapers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
