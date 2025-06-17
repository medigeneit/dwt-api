<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Http\Resources\DesignationResource;
use App\Models\Designation;
use App\Models\DidRegistration;
use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{
    public function index()
    {
        return response()->json(Designation::with(['user', 'college'])->paginate(20));
    }

    public function store(StoreDesignationRequest $request)
    {
        try {
            DB::beginTransaction();

            // 2. Get all validated data
            $data = $request->validated();
            
            // 4. Create record
            $designation = Designation::create($data);

            DB::commit();

            return response()->json([
                'message' => 'Designation created successfully',
                'designation' => new DesignationResource($designation),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create designation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        return response()->json(Designation::with(['user', 'college'])->findOrFail($id));
    }

    public function update(UpdateDesignationRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $designation = Designation::findOrFail($id);
            $designation->update($request->validated());

            DB::commit();

            return response()->json([
                'message' => 'Designation updated successfully',
                'designation' => new DesignationResource($designation),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to update designation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        Designation::findOrFail($id)->delete();
        return response()->json(['message' => 'Designation deleted successfully']);
    }

    public function getAmbassadors()
    {
        $ambassadors = $this->getByDesignationType('ambassador');

        if (!$ambassadors) {
            return response()->json(['message' => 'Invalid designation type.'], 422);
        }

        return response()->json([
            'data' => DesignationResource::collection($ambassadors) 
        ]);
    }

    public function getCoordinators()
    {
        $coordinators = $this->getByDesignationType('coordinator');

        if (!$coordinators) {
            return response()->json(['message' => 'Invalid designation type.'], 422);
        }

        return response()->json([
            'data' => DesignationResource::collection($coordinators)
        ]);
    }

    public function getByDesignationType($type)
    {
        $map = [
            'ambassador' => ['batch_ambassador', 'college_ambassador', 'zone_ambassador'],
            'coordinator' => ['divisional_coordinator', 'district_coordinator', 'upazila_coordinator', 'institutional_coordinator'],
        ];

        if (!isset($map[$type])) {
            return null;
        }

        return Designation::whereIn('type', $map[$type])->get();
    }


}
