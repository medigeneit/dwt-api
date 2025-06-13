<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function divisions(): JsonResponse {
        $divisions = DB::table('divisions')->select('id', 'name')->get();
        return response()->json($divisions);
    }

    public function districts(Request $request): JsonResponse {
        $districts = DB::table('districts')
            ->select('id', 'name')
            ->when($request->has('division_id'), function ($query) use ($request) {
                return $query->where('division_id', $request->input('division_id'));
            })
            // ->where('division_id', $divisionId)
            ->get();

        if ($districts->isEmpty()) {
            return response()->json(['message' => 'No districts found for this division'], 404);
        }

        return response()->json($districts);
    }

    public function upazilas($districtId): JsonResponse {
        $upazilas = DB::table('upazilas')
            ->select('id', 'name')
            ->where('district_id', $districtId)
            ->get();

        if ($upazilas->isEmpty()) {
            return response()->json(['message' => 'No upazilas found for this district'], 404);
        }

        return response()->json($upazilas);
    }
}
