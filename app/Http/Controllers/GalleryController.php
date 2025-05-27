<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        return response([
            'galleries' => GalleryResource::collection(Gallery::latest()->get()),
        ]);
    }

    public function show($id)
    {
        return Gallery::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'photo' => 'nullable|max:2048',
        ]);

        $gallery = Gallery::create($request->all());

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => $gallery,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $gallery = Gallery::findOrFail($id);

        $gallery->update($request->all());

        return response()->json([
            'message' => 'Gallery updated successfully',
            'gallery' => $gallery,
        ]);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        $gallery->delete();

        return response()->json(['message' => 'Gallery deleted successfully']);
    }
}
