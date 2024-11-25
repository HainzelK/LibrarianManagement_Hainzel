<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:book-list|book-create|book-edit|book-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:book-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:book-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:book-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        // Check user role
        if (auth()->user()->hasRole('admin')) {
            // Admin sees all books
            $books = Book::latest()->paginate(10);
        } else {
            // Others see only approved books
            $books = Book::where('status', 'approved')->latest()->paginate(10);
        }

        return view('books.index', compact('books'))
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book): View
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book): View
    {
        // Only allow editing if the book is pending
        if ($book->status !== 'pending') {
            abort(403, 'You can only edit pending books.');
        }

        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $request->validate([
            'title'        => 'required|min:3',
            'author'       => 'required|min:3',
            'category'     => 'required|min:3',
            'is_physical'  => 'required|boolean',
            'available'    => 'required|boolean',
        ]);

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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book): RedirectResponse
    {
        // Only allow deleting pending books
        if ($book->status !== 'pending') {
            abort(403, 'You can only delete pending books.');
        }

        $book->delete();

        return redirect()->route('books.index')->with(['success' => 'Book Successfully Deleted!']);
    }

    /**
     * Approve the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function approve(Book $book): RedirectResponse
    {
        // Approve the book
        $book->update(['status' => 'approved']);

        return redirect()->route('books.index')->with(['success' => 'Book Approved!']);
    }

    /**
     * Reject the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function reject(Book $book): RedirectResponse
    {
        // Reject the book
        $book->update(['status' => 'rejected']);

        return redirect()->route('books.index')->with(['success' => 'Book Rejected!']);
    }
}
