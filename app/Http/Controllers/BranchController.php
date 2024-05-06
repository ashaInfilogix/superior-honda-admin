<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::latest()->get();

        if (Auth::user()->can('view branch')) {
            return view('branches.index', compact('branches'));
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create branch')) {
            return view('branches.create');
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
            'name'    => 'required',
            'address' => 'required',
            'pincode' => 'required'
        ]);

        $branch = Branch::orderByDesc('unique_code')->first();
        if (!$branch) {
            $uniqueCode =  'BR0001';
        } else {
            $numericPart = (int)substr($branch->unique_code, 3);
            $nextNumericPart = str_pad($numericPart + 1, 4, '0', STR_PAD_LEFT);
            $uniqueCode = 'BR' . $nextNumericPart;
        }
    
        Branch::create([
            'name'          => $request->name,
            'timing'        => $request->timing,
            'unique_code'   => $uniqueCode,
            'operating_hours' => $request->operating_hours,
            'branch_head'   => $request->branch_head,
            'address'       => $request->address,
            'pincode'       => $request->pincode,
            'status'        => $request->status,
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch saved successfully'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $branch = Branch::where('id', $branch->id)->first();

        if (Auth::user()->can('edit branch')) {
            return view('branches.edit', compact('branch'));
        } else {
            return redirect()->route('dashboard.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'pincode' => 'required'
        ]);

        Branch::where('id', $branch->id)->update([
            'name'            => $request->name,
            'timing'          => $request->timing,
            'operating_hours' => $request->operating_hours,
            'branch_head'     => $request->branch_head,
            'address'         => $request->address,
            'pincode'         => $request->pincode,
            'status'          => $request->status,
        ]);

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        Branch::where('id', $branch->id)->delete();

        if (Auth::user()->can('delete branch')) {
            return response()->json([
                'success' => true,
                'message' => 'Branch deleted successfully.'
            ]);
        } else {
            return redirect()->route('dashboard.index');
        }
    }
}
