<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class RegisterEstablishmentController extends Controller
{
    public function create()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/departments');
        $departments = $response->json()['data'];

        $response = Http::get($url . '/v1/municipalities');
        $municipalities = $response->json()['data'];

        $response = Http::get($url . '/v1/establishment_types');
        $establishment_types = $response->json()['data'];

        return view('auth.RegisterEstablishment', [
            'departments' => $departments,
            'municipalities' => $municipalities,
            'establishment_types' => $establishment_types,
            'establishment' => null
        ]);
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate([
            'username' => 'required|string|max:255|min:5|unique:users',
            // 'email_address' => 'required|string|email|max:255|min:8|unique:users',
            'email_address' => 'required|string|email|max:255|min:8',
            'password' => ['required', 'confirmed', Password::default()],
            'name' => 'required|string',
            // 'phone_number' => 'required|integer|unique:people|unique:establishments',
            'phone_number' => 'required|integer',
            'zone_type' => 'required',
            'address' => 'required|string',
            'establishment_type_id' => 'required',
            'municipality_id' => 'required'
        ]);

        $response = Http::post($url . '/register/establishment', [
            'username' => $request->username,
            'email_address' => $request->email_address,
            'password' => $request->password,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'zone_type' => $request->zone_type,
            'address' => $request->address,
            'establishment_type_id' => $request->establishment_type_id,
            'municipality_id' => $request->municipality_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with(['success' => 'establecimiento creado']);
        } else {
            return redirect()->route('registerEstablishment')->withErrors(['error' => 'no se pudo crear el establecimiento']);
        }
    }
}
