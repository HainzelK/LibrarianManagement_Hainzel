<?php

namespace App\Http\Controllers;

use App\Models\Newspaper;  // Import the Newspaper model
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class NewspaperController extends Controller
{
    /**
     * Display a listing of the newspapers.
     *
     * @return View
     */
    public function index(): View
    {
        // Get all newspapers with pagination
        $newspapers = Newspaper::latest()->paginate(10);

        return view('newspapers.index', compact('newspapers'));
    }

    /**
     * Show the form for creating a new newspaper.
     *
     * @return View
     */
    public function create(): View
    {
        return view('newspapers.create');
    }

    /**
     * Store a newly created newspaper in the database.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate form data
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|in:Kompas,Tribun Timur,Fajar',
            'publication_date' => 'required|date',
            'status' => 'required|in:available,stored',
        ]);

        // Create a new newspaper
        Newspaper::create([
            'title' => $request->title,
            'publisher' => $request->publisher,
            'publication_date' => $request->publication_date,
            'status' => $request->status,
        ]);

        // Redirect to the newspaper index page with a success message
        return redirect()->route('newspapers.index')->with(['success' => 'Newspaper Created Successfully!']);
    }

    /**
     * Show the form for editing the specified newspaper.
     *
     * @param  string  $id
     * @return View
     */
    public function edit(string $id): View
    {
        // Find the newspaper by ID
        $newspaper = Newspaper::findOrFail($id);

        return view('newspapers.edit', compact('newspaper'));
    }

    /**
     * Update the specified newspaper in the database.
     *
     * @param  Request  $request
     * @param  string   $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validate form data
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|in:Kompas,Tribun Timur,Fajar',
            'publication_date' => 'required|date',
            'status' => 'required|in:available,stored',
        ]);

        // Find the newspaper by ID
        $newspaper = Newspaper::findOrFail($id);

        // Update the newspaper record
        $newspaper->update([
            'title' => $request->title,
            'publisher' => $request->publisher,
            'publication_date' => $request->publication_date,
            'status' => $request->status,
        ]);

        // Redirect to the newspaper index page with a success message
        return redirect()->route('newspapers.index')->with(['success' => 'Newspaper Updated Successfully!']);
    }

    /**
     * Remove the specified newspaper from the database.
     *
     * @param  string  $id
     * @return RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        // Find the newspaper by ID
        $newspaper = Newspaper::findOrFail($id);

        // Delete the newspaper record
        $newspaper->delete();

        // Redirect to the newspaper index page with a success message
        return redirect()->route('newspapers.index')->with(['success' => 'Newspaper Deleted Successfully!']);
    }

    /**
     * Mark the newspaper as stored after a week.
     *
     * @param  string  $id
     * @return RedirectResponse
     */
    public function markAsStored(string $id): RedirectResponse
    {
        // Find the newspaper by ID
        $newspaper = Newspaper::findOrFail($id);

        // Check if the newspaper was published more than a week ago
        if (Carbon::parse($newspaper->publication_date)->lt(Carbon::now()->subWeek())) {
            // Update the status to 'stored'
            $newspaper->update(['status' => Newspaper::STATUS_STORED]);

            // Redirect with a success message
            return redirect()->route('newspapers.index')->with(['success' => 'Newspaper Marked as Stored!']);
        }

        // If it's less than a week old, return with an error message
        return redirect()->route('newspapers.index')->with(['error' => 'Newspaper is not yet a week old!']);
    }
}
