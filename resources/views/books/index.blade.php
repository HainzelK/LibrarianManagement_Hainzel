<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books List - Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-4">Books List</h4>
                            @if(auth()->user()->hasRole('librarian'))
                                <a href="{{ route('books.create') }}" class="btn btn-success">Add New Book</a>
                            @endif
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
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->category }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($book->status == 'pending') bg-warning
                                                @elseif($book->status == 'approved') bg-success
                                                @elseif($book->status == 'rejected') bg-danger
                                                @endif">
                                                {{ ucfirst($book->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(auth()->user()->hasRole('librarian') && $book->status === 'pending')
                                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                                <!-- Delete Form -->
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirmDelete()">Delete</button>
                                                </form>
                                            @endif

                                            @if(auth()->user()->hasRole('admin') && $book->status === 'pending')
                                                <form action="{{ route('books.approve', $book->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                </form>

                                                <form action="{{ route('books.reject', $book->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Custom delete confirmation
        function confirmDelete() {
            event.preventDefault(); // Prevents the form from submitting immediately
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit(); // Submit the form if confirmed
                }
            });
        }
    </script>
</body>
</html>
