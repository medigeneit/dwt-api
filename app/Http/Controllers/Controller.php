<?php

namespace App\Http\Controllers;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Http;
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

    public function sendSMS($phone, $message, $event = null)
    {

        
        $postvars = array(
            'username'      => "BGHRI",
            'password'      => "Bghr!@2022",
            'apicode'       => "5",
            'msisdn'        => [$phone],
            'countrycode'   => "880",
            'cli'           => "BGHRI",
            'messagetype'   => preg_match('/^[a-z0-9 .\-]+$/i',  $message) ? '1' : '3',
            'message'       => $message,
            'clienttransid' => uniqid(),
            'bill_msisdn'   => "8801969906275",
            'tran_type'     => "T",
            'request_type'  => "S",
        );

        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json'
        ];

        $url = "https://corpsms.banglalink.net/bl/api/v1/smsapigw/";

        
        $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders($headers)->post($url, $postvars);

        $responseData = $response->json();

        $statusCode = $responseData['statusInfo']['statusCode'] ?? 'UNKNOWN';

         // ✅ Save log
        SmsLog::create([
            'phone' => $phone,
            'message' => $message,
            'event' => $event,
            'status_code' => $statusCode,
            'response_raw' => json_encode($responseData),
        ]);

        return $statusCode;

        // return $this->storeSmsLog($number, $event, $delivery_status, $admin_id, $doctor_id);
    }

}
