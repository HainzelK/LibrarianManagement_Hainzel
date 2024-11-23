<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function __construct()
    {
        $this->middleware('role:admin')->only(['approve', 'reject']); // Admin-only actions
        $this->middleware('role:librarian')->only(['create', 'store', 'edit', 'update', 'destroy']); // Librarian actions
    }
    public function index(): View
    {
        // Check user role
        if (auth()->user()->hasRole('admin')) {
            // Admin sees all books
            $books = Book::latest()->paginate(10);
        } else {
            // Others see only approved books
            $books = Book::where('status', 'approved')->latest()->paginate(10);
        }

        return view('books.index', compact('books'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

        // Create a book with status pending
        Book::create([
            'title'        => $request->title,
            'author'       => $request->author,
            'category'     => $request->category,
            'is_physical'  => $request->is_physical,
            'available'    => $request->available,
            'status'       => 'pending', // Default status
        ]);

        return redirect()->route('books.index')->with(['success' => 'Book Successfully Created and Pending Approval!']);
    }

    /**
     * edit
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        $book = Book::findOrFail($id);

        // Only allow editing if the book is pending
        if ($book->status !== 'pending') {
            abort(403, 'You can only edit pending books.');
        }

        return view('books.edit', compact('book'));
    }

    /**
     * update
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

        $book = Book::findOrFail($id);

        // Update book details and reset to pending status
        $book->update([
            'title'        => $request->title,
            'author'       => $request->author,
            'category'     => $request->category,
            'is_physical'  => $request->is_physical,
            'available'    => $request->available,
            'status'       => 'pending', // Reset status to pending
        ]);

        return redirect()->route('books.index')->with(['success' => 'Book Updated and Pending Approval!']);
    }

    /**
     * destroy
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        // Only allow deleting pending books
        if ($book->status !== 'pending') {
            abort(403, 'You can only delete pending books.');
        }

        $book->delete();

        return redirect()->route('books.index')->with(['success' => 'Book Successfully Deleted!']);
    }

    /**
     * approve
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function approve(string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        // Approve the book
        $book->update(['status' => 'approved']);

        return redirect()->route('books.index')->with(['success' => 'Book Approved!']);
    }

    /**
     * reject
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function reject(string $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        // Reject the book
        $book->update(['status' => 'rejected']);

        return redirect()->route('books.index')->with(['success' => 'Book Rejected!']);
    }

}
