<?php

namespace App\Http\Controllers;

use App\Models\DonorMember;
use Illuminate\Http\Request;

class DonorMemberController extends Controller
{

    public function index()
    {
        $records = DonorMember::latest()->paginate(20);
        return view('admin.donor_members.index', compact('records'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'member_type' => 'required|string',
            'name' => 'required|string',
            'father_name' => 'nullable|string',
            'is_foreign' => 'boolean',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'district' => 'nullable|string',
            'thana' => 'nullable|string',
            'address' => 'nullable|string',
            'donor_type' => 'required|string',
            'donation_purpose' => 'required|string',
            'donation_scope' => 'required|string',
            'amount' => 'nullable|numeric',
        ]);

        $record = DonorMember::create($data);

        return response()->json([
            'message' => 'Form submitted successfully',
            'data' => $record,
        ], 201);
    }

    public function show($id)
    {
        $record = DonorMember::findOrFail($id);
        return view('admin.donor_members.show', compact('record'));
    }

}
