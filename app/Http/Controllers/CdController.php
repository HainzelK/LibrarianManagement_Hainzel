<?php

namespace App\Http\Controllers;

use App\Models\Cd;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CdController extends Controller
{
    /**
     * Display a listing of the CDs.
     *
     * @return View
     */
    public function index(): View
    {
        // Fetch all CDs with pagination
        $cds = Cd::latest()->paginate(10);

        return view('cds.index', compact('cds'));
    }

    /**
     * Show the form for creating a new CD.
     *
     * @return View
     */
    public function create(): View
    {
        return view('cds.create');
    }

    /**
     * Store a newly created CD in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'description' => 'required|string',
            'is_accessible' => 'required|in:requested,granted,denied', // Validate access status
        ]);

        // Create the new CD entry
        Cd::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'publication_date' => $request->publication_date,
            'description' => $request->description,
            'is_accessible' => $request->is_accessible, // Store the selected access status
        ]);

        // Redirect to the index page with a success message
        return redirect()->route('cds.index')->with(['success' => 'CD Successfully Created!']);
    }

    /**
     * Show the form for editing the specified CD.
     *
     * @param string $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Get the CD by ID
        $cd = Cd::findOrFail($id);

        return view('cds.edit', compact('cd'));
    }

    /**
     * Update the specified CD in storage.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validate form data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'publication_date' => 'required|date',
            'description' => 'required|string',
            'is_accessible' => 'required|in:requested,granted,denied', // Validate access status
        ]);

        // Find the CD by ID
        $cd = Cd::findOrFail($id);

        // Update the CD entry
        $cd->update([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'publication_date' => $request->publication_date,
            'description' => $request->description,
            'is_accessible' => $request->is_accessible, // Update the access status
        ]);

        // Redirect back with a success message
        return redirect()->route('cds.index')->with(['success' => 'CD Successfully Updated!']);
    }

    /**
     * Remove the specified CD from storage.
     *
     * @param string $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        // Find the CD by ID
        $cd = Cd::findOrFail($id);

        // Delete the CD entry
        $cd->delete();

        // Redirect back with a success message
        return redirect()->route('cds.index')->with(['success' => 'CD Successfully Deleted!']);
    }
}
