<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CollegeController extends Controller
{
    public function index(){
       
        return response([
            'colleges' => College::get(['id','name']),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Row 0 & 1 skip, data starts from row 2
        for ($i = 2; $i < count($data); $i++) {
            $row = $data[$i];
            if (isset($row[1], $row[2], $row[3], $row[4])) {
                College::create([
                    'code' => $row[1],
                    'name' => $row[2],
                    'university' => $row[3],
                    'location' => $row[4],
                ]);
            }
        }

        return response()->json(['message' => 'Imported successfully']);
    }
}
