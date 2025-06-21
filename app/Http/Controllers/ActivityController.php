<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return response([
            'activities' => ActivityResource::collection(Activity::latest()->get()),
        ]);
    }

    public function show($id)
    {
        return new ActivityResource(Activity::findOrFail($id));
    }

    public function store(StoreActivityRequest $request)
    {

        
        $data = $request->validated();

        // Handle photo upload if exists
        // if ($request->hasFile('photo')) {
        //     $data['photo'] = $request->file('photo')->store('activities', 'public');
        // }

        $activity = Activity::create($data);

        return response()->json([
            'message' => 'Activity created successfully',
            'activity' => new ActivityResource($activity),
        ], 201);
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'title'         => 'required|string|max:255|unique:activities,title,' . $id,
            'category'      => 'required|string',
            'description'   => 'required|string',
            'location'      => 'nullable|string|max:255',
            'activity_date' => 'nullable|date',
            'photo'         => 'nullable',
            'status'        => 'required|in:active,inactive',
        ]);

        $activity = Activity::findOrFail($id);
        $activity->update($request->all());

        return response()->json([
            'message' => 'Activity updated successfully',
            'activity' => new ActivityResource($activity),
        ]);
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return response()->json(['message' => 'Activity deleted successfully']);
    }
}
