<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/find/users/'. session('user_id'));
        $users = $response->json()['data'];

        return view('admin.userAccount.ManagementUserAccountsView', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function setAccountStatus($id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/users/account_status/'. $id);

        if ($response->successful()) {
            return redirect()->route('user_accounts.index')->with(['success' => 'cuenta de usuario actualizada']);
        } else {
            return redirect()->route('user_accounts.index')->withErrors(['error' => 'no se pudo actualizar la cuenta de usuario']);
        }
    }
}
