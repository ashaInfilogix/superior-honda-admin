<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = user::latest()->get();

        if (Auth::user()->can('view user')){
            return view('users.index', compact('users'));
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::latest()->get();
        $roles = Role::latest()->get();
        if (Auth::user()->can('create user'))
        {
            return view('users.create', compact('branches', 'roles'));
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'designation'   => 'required',
            'role'          => 'required'
        ]);

        $user = User::orderByDesc('emp_id')->first();
        if (!$user) {
            $empId =  'Em0001';
        } else {
            $numericPart = (int)substr($user->emp_id, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $empId = 'Em' . $nextNumericPart;
        }

        user::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'designation'   => $request->designation,
            'branch_id'     => $request->branch,
            'emp_id'        => $empId,
            'additional_details' => $request->additional_detail,
            'date_of_birth' => $request->date_of_birth,
            'password'      => Hash::make(Str::random(10)),
        ])->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (Auth::user()->can('edit user')){
            $branches = Branch::latest()->get();
            $roles = Role::latest()->get();
            return view('users.edit', compact('user', 'branches', 'roles'));
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'designation'   => 'required',
            'role'          => 'required'
        ]);
        user::where('id', $user->id)->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'branch_id'     => $request->branch,
            'date_of_birth' => $request->date_of_birth,
            'additional_details' => $request->additional_detail,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::where('id', $user->id)->delete();

        if(Auth::user()->can('delete user')) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        } else {
            return redirect()->route('dashboard.index');
        }
    }
}