<?php

namespace App\Http\Controllers;

use App\Models\Profile;

abstract class Controller
{
    public function generateDID($profile)
    {
        $prefix = '1';

        $collegeCode = $profile->college?->code ?? '000';

        // Extract last 3 digits from session_year
        $session = $profile->session_year;

        $sessionCode = '000';

        if ($session && preg_match('/\d{4}-\d{4}/', $session)) {
            $parts = explode('-', $session);
            $sessionCode = substr($parts[1], -3); // 2013-2014 → 014
        }

        $serial = Profile::where('college_id', $profile->college_id)
                        ->where('session_year', $profile->session_year)
                        ->where('batch', $profile->batch)
                        ->count() + 1;

        $serialFormatted = str_pad($serial, 3, '0', STR_PAD_LEFT); // 001, 002...

        return "{$prefix}_{$collegeCode}_{$sessionCode}_{$serialFormatted}";
    }

}
