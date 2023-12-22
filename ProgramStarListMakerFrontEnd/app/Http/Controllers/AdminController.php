<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function welcomeAdmin()
    {
        return view('admin.WelcomeAdminView');
    }

    public function welcomeEstablishment()
    {
        return view('admin.WelcomeEstablishmentView');
    }

    public function welcomeUser()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/enable/categories');
        $categories = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/brands');
        $brands = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/products');
        $products = $response->json()['data'];

        return view('admin.WelcomeUserView', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products
        ]);
    }

    public function getProductsByCategory($id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/enable/categories');
        $categories = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/brands');
        $brands = $response->json()['data'];

        if ($id == 'all') {
            $response = Http::get($url . '/v1/enable/products');
            $products = $response->json()['data'];
        } else {
            $response = Http::get($url . '/v1/categories/' . $id);
            $category = $response->json()['data'];

            if ($category && $category['state'] == true) {
                $products = $category['products'];
            }
        }

        return view('admin.WelcomeUserView', [
            'category_id' => $id,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products
        ]);
    }

    public function getProductsByBrand($id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/enable/categories');
        $categories = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/brands');
        $brands = $response->json()['data'];

        if ($id == 'all') {
            $response = Http::get($url . '/v1/enable/products');
            $products = $response->json()['data'];
        } else {
            $response = Http::get($url . '/v1/brands/' . $id);
            $brand = $response->json()['data'];

            if ($brand && $brand['state'] == true) {
                $products = $brand['products'];
            }
        }

        return view('admin.WelcomeUserView', [
            'brand_id' => $id,
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products
        ]);
    }

    public function getProductsByName(Request $request)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/enable/categories');
        $categories = $response->json()['data'];

        $response = Http::get($url . '/v1/enable/brands');
        $brands = $response->json()['data'];

        if ($request->search == '') {
            $response = Http::get($url . '/v1/enable/products');
            $products = $response->json()['data'];
        } else {
            $response = Http::post($url . '/v1/search/products', [
                'search' => $request->search,
            ]);
            $products = $response->json()['data'];
        }

        return view('admin.WelcomeUserView', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products
        ]);
    }
}
