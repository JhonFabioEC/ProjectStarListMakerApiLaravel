<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AuthenticationSessionController extends Controller
{
    public function create()
    {
        return view('auth.Login');
    }

    public function store(Request $request)
    {
        $url = env('URL_SERVER_API');

        $request->validate(
            [
                'email_address' => 'required|string|email|max:255|min:8',
                'password' => 'required|string'
            ]
        );

        $response = Http::post($url . '/login', [
            'email_address' => $request->email_address,
            'password' => $request->password,
            'name' => 'browser',
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if ($data['account_status'] == false) {
                return redirect()->route('login')->with(['error' => 'Cuenta de usuario bloqueada']);
            }

            $request->session()->put('api_token', $data['token']);
            $request->session()->put('user_id', $data['id']);
            $request->session()->put('user_name', $data['username']);
            $request->session()->put('user_email', $data['email_address']);
            $request->session()->put('user_role_type', $data['role_type_id']);
            $request->session()->put('user_account_status', $data['account_status']);
            $request->session()->put('user_image', $data['image']);

            //Crear el archivo de la sesión
            //Almacenando datos mientras esta en la sesión
            $request->session()->regenerate();

            if (session('user_role_type') == 1) {
                return redirect()->route('welcome_admin');
            } elseif (session('user_role_type') == 2) {
                return redirect()->route('welcome_establishment');
            } elseif (session('user_role_type') == 3) {
                return redirect()->route('welcome_user');
            }

            return redirect()->route('welcomeAdmin');
        } else {
            return redirect()->route('login')->with(['error' => 'Credenciales invalidas']);
        }
    }

    public function destroy(Request $request)
    {
        $url = env('URL_SERVER_API');

        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $request->session()->get('api_token')])->post($url . '/logout');

        if ($response->successful()) {
            $request->session()->forget('api_token');
            //Destruir el archivo de sesión
            $request->session()->invalidate();
            //Obtener un nuevo token
            $request->session()->regenerateToken();

            return redirect()->route('login');
        } else {
            return redirect()->route('home')->with(['error' => 'Error al cerrar sesión']);
        }
    }
}
