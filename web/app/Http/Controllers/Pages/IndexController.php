<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\EarlyAccessUsers;
use App\Models\Lead;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        return view('pages.index');
    }

    // Crea mensaje de contacto y se envia a la base de datos
    public function storeLead(Request $request) {

        // Valida la informacion enviada
            $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        do {
            $leadId = Str::uuid();
        } while (Lead::where('lead_id', $leadId)->exists());

        $ip = $request->ip();
        if ($ip === "127.0.0.1") {
            $ip = "8.8.8.8"; // Para pruebas locales
        }

        $token = env('IPINFO_TOKEN');
        $url = "https://ipinfo.io/{$ip}/json?token={$token}";
        $response = @file_get_contents($url);
        $data = $response ? json_decode($response, true) : [];

        $timezone = $data['timezone'];

        // Crea el mensaje en la base de datos
        Lead::create([
            'lead_id' => $leadId,
            'reason' => $request->input('reason'),
            'name' => $request->input("name"),
            'email' => $request->input("email"),
            'message' => $request->input("message"),
            'ip_address' => $ip,
            'timezone' => $timezone,
        ]);

        return redirect('/')->with('successContactSubmit', true);
    }

    public function storeEarlyUser(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|max:250',
        ]);

        EarlyAccessUsers::create([
            'name' => $request->input("name"),
            'phone' => $request->input("phone"),
            'email' => $request->input("email"),
            'shop_type' => $request->input("shop_type"),
        ]);

        return redirect('/')->with('successEarlyAccessUsersSubmit', true);
    }
}
