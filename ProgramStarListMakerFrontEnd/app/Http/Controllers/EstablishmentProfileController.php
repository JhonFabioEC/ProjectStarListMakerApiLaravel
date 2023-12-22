<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class EstablishmentProfileController extends Controller
{
    public function index()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/departments');
        $departments = $response->json()['data'];

        $response = Http::get($url . '/v1/municipalities');
        $municipalities = $response->json()['data'];

        $response = Http::get($url . '/v1/establishment_types');
        $establishment_types = $response->json()['data'];

        $response = Http::get($url . '/v1/users/' . session('user_id'));
        $user = $response->json()['data'];

        $establishment = $user['establishments'];

        return view('admin.establishment.EstablishmentView', [
            'departments' => $departments,
            'municipalities' => $municipalities,
            'establishment_types' => $establishment_types,
            'establishment' => $establishment[0]
        ]);
    }

    public function edit()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/departments');
        $departments = $response->json()['data'];

        $response = Http::get($url . '/v1/municipalities');
        $municipalities = $response->json()['data'];

        $response = Http::get($url . '/v1/establishment_types');
        $establishment_types = $response->json()['data'];

        $response = Http::get($url . '/v1/users/' . session('user_id'));
        $user = $response->json()['data'];

        $establishment = $user['establishments'];

        return view('admin.establishment.EditEstablishmentView', [
            'departments' => $departments,
            'municipalities' => $municipalities,
            'establishment_types' => $establishment_types,
            'establishment' => $establishment[0]
        ]);
    }

    public function update(Request $request)
    {
        $session = app('session');
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/users/' . session('user_id'));
        $user = $response->json()['data'];

        $establishment = $user['establishments'];

        $request->validate([
            'image' => 'image|mimes:jpg,png,jpeg|max:2040',
            // 'email_address' => 'required|string|email|max:255|min:8|unique:users,email_address,' . Auth::user()->id,
            'email_address' => 'required|string|email|max:255|min:8',
            'password' => ['nullable', Password::default()],
            'name' => 'required|string',
            // 'phone_number' => 'required|integer|unique:people|unique:establishments,phone_number,' . $establishment[0]->id,
            'phone_number' => 'required|integer',
            'zone_type' => 'required',
            'address' => 'required|string',
            'department_id' => 'required',
            'municipality_id' => 'required',
            'establishment_type_id' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            if ($establishment[0]['user']['image'] && $establishment[0]['user']['image'] != 'default.svg' && File::exists(public_path('storage/users/establishments/' . $establishment[0]['user']['image']))) {
                File::delete(public_path('storage/users/establishments/' . $establishment[0]['user']['image']));
            }

            $request->image->move(public_path('storage/users/establishments'), $imageName);

            $response = Http::put($url . '/v1/establishment/' . $establishment[0]['id'], [
                'image' => $imageName
            ]);

            $session->put('user_image', $imageName);
        }

        if ($request->filled('password') && $request->password !== $establishment[0]['user']['password']) {
            $response = Http::put($url . '/v1/establishment/' . $establishment[0]['id'], [
                'password' => bcrypt($request->password)
            ]);
        }

        $response = Http::put($url . '/v1/establishment/' . $establishment[0]['id'], [
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'zone_type' => $request->zone_type,
            'address' => $request->address,
            'municipality_id' => $request->municipality_id,
            'establishment_type_id' => $request->establishment_type_id,
            'email_address' => $request->email_address
        ]);

        $session->put('user_email', $request->email_address);

        if ($response->successful()) {
            return redirect()->route('establishment_profile')->with(['success' => 'usuario actualizado']);
        } else {
            return redirect()->route('establishment_edit_profile')->withErrors(['error' => 'no se pudo actualizar el usuario']);
        }
    }

    public function destroy($id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/users/' . $id);
        $user = $response->json()['data'];

        $establishment = $user['establishments'];

        if ($establishment[0]['user']['image'] && $establishment[0]['user']['image'] != 'default.svg' && File::exists(public_path('storage/users/establishments/' . $establishment[0]['user']['image']))) {
            File::delete(public_path('storage/users/establishments/' . $establishment[0]['user']['image']));
        }

        $response = Http::delete($url . '/v1/establishment/' . $establishment[0]['id']);

        if ($response->successful()) {
            return redirect()->route('logout')->with(['success' => 'establecimiento eliminado']);
        } else {
            return redirect()->route('establishment_edit_profile')->withErrors(['error' => 'el establecimiento no puede ser eliminado']);
        }
    }
}
