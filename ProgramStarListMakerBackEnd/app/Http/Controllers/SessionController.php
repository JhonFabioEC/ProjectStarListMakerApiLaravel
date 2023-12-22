<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use App\Models\Establishment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email_address', 'password'))) {
            $user = $request->user();

            return response()->json([
                //Generar token (clave) para el servicio autenticado
                //si hay clave puede consumir los servicios
                'token' => $user->createToken($request->name)->plainTextToken,
                'id' => $user->id,
                'username' => $user->username,
                'email_address' => $user->email_address,
                'role_type_id' => $user->roleType->id,
                'account_status' => $user->account_status,
                'image' => $user->image,
                'message' => 'Success'
            ], Response::HTTP_ACCEPTED);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Successfully logged out'
            ], Response::HTTP_ACCEPTED);
        } else {
            return response()->json([
                'message' => 'User not authenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function registerPerson(Request $request)
    {
        $user = new User(
            [
                'image' => 'default.svg',
                'username' => $request->username,
                'email_address' => $request->email_address,
                'password' => bcrypt($request->password),
                'account_status' => true,
                'role_type_id' => 3
            ]
        );

        $user->save();

        $person = new Person(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birth_date' => $request->birth_date,
                'sex' => $request->sex,
                'document_number' => $request->document_number,
                'phone_number' => $request->phone_number,
                'zone_type' => $request->zone_type,
                'address' => $request->address,
                'user_id' => $user->id,
                'document_type_id' => $request->document_type_id,
                'municipality_id' => $request->municipality_id,
            ]
        );

        $person->save();

        return response()->json([
            'message' => 'Person registered',
            'data' => $person
        ], Response::HTTP_ACCEPTED);
    }

    public function registerEstablishment(Request $request)
    {
        $user = new User(
            [
                'image' => 'default.svg',
                'username' => $request->username,
                'email_address' => $request->email_address,
                'password' => bcrypt($request->password),
                'account_status' => true,
                'role_type_id' => 2
            ]
        );

        $user->save();

        $establishment = new Establishment(
            [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'zone_type' => $request->zone_type,
                'address' => $request->address,
                'user_id' => $user->id,
                'establishment_type_id' => $request->establishment_type_id,
                'municipality_id' => $request->municipality_id,
            ]
        );

        $establishment->save();

        return response()->json([
            'message' => 'Establishment registered',
            'data' => $establishment
        ], Response::HTTP_ACCEPTED);
    }
}
