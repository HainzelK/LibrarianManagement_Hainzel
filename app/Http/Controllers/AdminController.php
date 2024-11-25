<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Ensure only admins can access certain actions
        $this->middleware('role:admin')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('role:librarian')->only(['index']); // Librarians can view users if needed
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        // Only admins can see all users (students, librarians, admins)
        if (auth()->user()->hasRole('admin')) {
            $data = User::latest()->paginate(5);
        } else {
            // Librarians can see only their own assigned users or specific collections
            $data = User::whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->latest()->paginate(5);
        }

        return view('users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        // Admin can assign roles, while librarian cannot
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Only admin can create users.');
        }

        $roles = Role::pluck('name', 'name')->all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        // Only admins or the user themselves can edit the profile
        $user = User::find($id);

        if (!auth()->user()->hasRole('admin') && auth()->id() != $user->id) {
            abort(403, 'You do not have permission to edit this user.');
        }

        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        // Admin can delete users, but librarians cannot
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Only admin can delete users.');
        }

        User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
