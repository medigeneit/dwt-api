<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAboutUsRequest;
use App\Http\Requests\UpdateAboutUsRequest;
use App\Http\Resources\AboutUsResource;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
     public function index()
    {
        return response([
            'about_us' => AboutUsResource::collection(AboutUs::latest()->get()),
        ]);
    }

    public function show($id)
    {
        return new AboutUsResource(AboutUs::findOrFail($id));
    }

    public function store(StoreAboutUsRequest $request)
    {
        try {
            DB::beginTransaction();

            $about = AboutUs::create($request->validated());

            DB::commit();

            return response()->json([
                'message' => 'About Us content created successfully',
                'about' => new AboutUsResource($about),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create About Us content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateAboutUsRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $about = AboutUs::findOrFail($id);
            $about->update($request->validated());

            DB::commit();

            return response()->json([
                'message' => 'About Us content updated successfully',
                'about' => new AboutUsResource($about),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update About Us content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $about = AboutUs::findOrFail($id);
            $about->delete();
            return response()->json(['message' => 'About Us content deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete About Us content',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
