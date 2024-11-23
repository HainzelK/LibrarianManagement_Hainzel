<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Journals List - Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-4">Journals List</h4>
                            <a href="{{ route('journals.create') }}" class="btn btn-success">Add New Journal</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Publication Date</th>
                                    <th>Access Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($journals as $journal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $journal->title }}</td>
                                        <td>{{ $journal->author }}</td>
                                        <td>{{ $journal->category }}</td>
                                        <td>{{ $journal->publication_date }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($journal->is_accessible == 'requested') badge-warning
                                                @elseif($journal->is_accessible == 'granted') badge-success
                                                @elseif($journal->is_accessible == 'denied') badge-danger
                                                @endif">
                                                {{ ucfirst($journal->is_accessible) }}
                                            </span>
                                        </td>
                                        <td>
                                        <form action="{{ route('journals.destroy', $journal->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $journals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
