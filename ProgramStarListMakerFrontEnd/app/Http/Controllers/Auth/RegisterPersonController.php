<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class RegisterPersonController extends Controller
{
    public function create()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/departments');
        $departments = $response->json()['data'];

        $response = Http::get($url . '/v1/municipalities');
        $municipalities = $response->json()['data'];

        $response = Http::get($url . '/v1/document_types');
        $document_types = $response->json()['data'];

        return view('auth.RegisterPerson', [
            'departments' => $departments,
            'municipalities' => $municipalities,
            'document_types' => $document_types,
            'person' => null
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'birth_date' => 'required|date',
            'document_number' => 'required|integer|unique:people',
            // 'phone_number' => 'required|integer|unique:people|unique:establishments',
            'phone_number' => 'required|integer',
            'zone_type' => 'required',
            'address' => 'required|string',
            'document_type_id' => 'required',
            'municipality_id' => 'required'
        ]);

        $response = Http::post($url . '/register/person', [
            'username' => $request->username,
            'email_address' => $request->email_address,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'sex' => $request->sex,
            'document_number' => $request->document_number,
            'phone_number' => $request->phone_number,
            'zone_type' => $request->zone_type,
            'address' => $request->address,
            'document_type_id' => $request->document_type_id,
            'municipality_id' => $request->municipality_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with(['success' => 'usuario creado']);
        } else {
            return redirect()->route('registerPerson')->withErrors(['error' => 'no se pudo crear el usuario']);
        }
    }
}
