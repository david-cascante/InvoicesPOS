<?php

namespace App\Http\Controllers\License;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\License;
use App\Models\User;
use Carbon\Carbon;

class LicenseController extends Controller
{
    public function storeLicense(Request $request) {
        $userId = $request->query('user_id');

        $plan = $request->input('plan');
        $duration = $request->input('duration');
        $transactionPaypalId = $request->input('transaction_paypal_id');
        
        if (!$userId ||!$plan ||!$duration ||!$transactionPaypalId) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_MISSING_DATA',
                'message' => 'Todos los parametros y datos deben de estar completos.'
            ], 400);
        };

        $userData = User::where('user_id', $userId)->where('status', 'active')->select('id')->first();

        if (!$userData) {
            return response()->json([
                'status' => false,
                'code' => 'ERR_USER_NOT_FOUND',
                'message' => 'El usuario especificado no se encuentra registrado.'
            ], 404);
        };

        do {
            $licenseKey = Str::uuid();
            $licenseId = uniqid();
        } while (License::where('license_key', $licenseKey)->orWhere('license_id', $licenseId)->exists());
        
        $nowDate = Carbon::now();

        if ($duration == '1_month') $totalDuration = $nowDate->addMonth(1);
        if ($duration == '3_month') $totalDuration = $nowDate->addMonth(3);
        if ($duration == '6_month') $totalDuration = $nowDate->addMonth(6);
        if ($duration == '1_year') $totalDuration = $nowDate->addYears(1);

        $ip = $request->ip();
        if ($ip === "127.0.0.1") {
            $ip = "8.8.8.8"; // Para pruebas locales
        }

        License::create([
            'license_id' => $licenseId,
            'user_id' => $userData->id,
            'license_key' => $licenseKey,
            'plan' => $plan,
            'duration' => $duration,
            'transaction_paypal_id' => '00000000',
            'start_date' => $nowDate,
            'end_date' => $totalDuration,
            'ip_address' => $ip,
        ]);

        return response()->json([
            'status' => true,
            'code' => 'SUCCESS_LICENSE_CREATED',
            'message' => "Licencia registrada con exito.",
        ], 201);
    }
}
