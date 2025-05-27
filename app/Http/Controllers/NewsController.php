<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return response([
            'news' => NewsResource::collection(News::latest()->get()),
        ]);
    }

    public function show($id)
    {
        return new NewsResource(News::findOrFail($id));
    }

    public function store(NewsRequest $request)
    {
   
        $news = News::create($request->all());

        return response()->json([
            'message' => 'Activity created successfully',
            'news' => new NewsResource($news),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $news = News::findOrFail($id);

        $news->update($request->all());

        return response()->json([
            'message' => 'Activity updated successfully',
            'news' => new NewsResource($news),
        ]);
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        $news->delete();

        return response()->json(['message' => 'News deleted successfully']);
    }
}
