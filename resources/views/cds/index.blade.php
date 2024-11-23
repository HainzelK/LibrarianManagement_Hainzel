<!-- resources/views/cds/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDs List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="my-4">CDs</h1>
    <a href="{{ route('cds.create') }}" class="btn btn-primary mb-3">Add New CD</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Publication Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cds as $cd)
                <tr>
                    <td>{{ $cd->title }}</td>
                    <td>{{ $cd->author }}</td>
                    <td>{{ $cd->category }}</td>
                    <td>{{ $cd->publication_date }}</td>
                    <td>{{ $cd->is_accessible }}</td>
                    <td>
                        <a href="{{ route('cds.edit', $cd->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete form -->
                        <form action="{{ route('cds.destroy', $cd->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    {{ $cds->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
