<?php

namespace App\Http\Controllers;

use App\Models\Journal; // Import the Journal model
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JournalController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        // Get all journals with pagination
        $journals = Journal::latest()->paginate(10);

        // Render view with journals
        return view('journals.index', compact('journals'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('journals.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form data

        $request->validate([
            'is_accessible' => 'required|in:requested,granted,denied', // Ensures it's one of the valid values
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'description' => 'required|string',
        ]);
        
        // Storing or updating the journal
        Journal::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'publication_date' => $request->publication_date,
            'description' => $request->description,
            'is_accessible' => $request->is_accessible,  // Ensure the correct value is assigned
        ]);
        

        // Redirect to index with success message
        return redirect()->route('journals.index')->with(['success' => 'Journal Successfully Created!']);
    }

    /**
     * requestAccess
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function requestAccess(string $id): RedirectResponse
    {
        // Get journal by ID
        $journal = Journal::findOrFail($id);

        // Create a request record for access (you can create a new model for this, if needed)
        // For simplicity, let's just update a status or log the request in the journal model
        $journal->update(['is_accessible' => 'requested']);

        // Redirect back with a message
        return redirect()->route('journals.index')->with(['success' => 'Access Request Sent!']);
    }

    /**
     * grantAccess
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function grantAccess(string $id): RedirectResponse
    {
        // Get journal by ID
        $journal = Journal::findOrFail($id);

        // Update journal to mark as accessible
        $journal->update(['is_accessible' => true]);

        // Redirect back with a message
        return redirect()->route('journals.index')->with(['success' => 'Access Granted to Journal!']);
    }

    /**
     * show
     *
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        // Get journal by ID
        $journal = Journal::findOrFail($id);

        // Render view with journal details
        return view('journals.show', compact('journal'));
    }

    /**
     * edit
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Get journal by ID
        $journal = Journal::findOrFail($id);

        // Render view with journal details
        return view('journals.edit', compact('journal'));
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
        // Validate form data
        $request->validate([
            'title'       => 'required|min:3',
            'author'      => 'required|min:3',
            'category'    => 'required|min:3',
            'publication_date' => 'required|date',
            'description' => 'required|min:10',
        ]);

        // Get journal by ID
        $journal = Journal::findOrFail($id);

        // Update journal details
        $journal->update([
            'title'           => $request->title,
            'author'          => $request->author,
            'category'        => $request->category,
            'publication_date'=> $request->publication_date,
            'description'     => $request->description,
        ]);

        // Redirect back with a success message
        return redirect()->route('journals.index')->with(['success' => 'Journal Successfully Updated!']);
    }

    /**
     * destroy
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        // Get journal by ID
        $journal = Journal::findOrFail($id);

        // Delete the journal entry
        $journal->delete();

        // Redirect to index with success message
        return redirect()->route('journals.index')->with(['success' => 'Journal Successfully Deleted!']);
    }
}
