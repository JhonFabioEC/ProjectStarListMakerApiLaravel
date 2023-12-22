<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ItemOrderController extends Controller
{
    public function getOrders()
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/users/' . session('user_id'));
        $user = $response->json()['data'];

        $item_orders = $user['persons'][0]['itemOrders'];

        return view('admin.person.OrdersView', ['item_orders' => $item_orders]);
    }

    public function addProduct($id, $quantity)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/products/' . $id);
        $product = $response->json()["data"];

        $response = Http::get($url . '/v1/users/' . session('user_id'));
        $user = $response->json()['data'];

        $person = $user['persons'];

        $sourceFolder = public_path('storage/products/');
        $destinationFolder = public_path('storage/itemOrders/');
        $imageName = $product['image'];

        $extension = File::extension($sourceFolder . $imageName);
        $newImageName = time() . '.' . $extension;

        if (File::exists($sourceFolder . $imageName)) {
            File::copy($sourceFolder . $imageName, $destinationFolder . $newImageName);
        }

        $response = Http::post($url . '/v1/item_orders', [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'barcode' => $product['barcode'],
            'image' => $newImageName,
            'category' => $product['category']['name'],
            'brand' => $product['brand']['name'],
            'establishment' => $product['establishment']['name'],
            'person_id' => $person[0]['id']
        ]);

        if ($response->successful()) {
            return redirect()->route('welcome_user')->with(['success' => 'producto ' . $product['name'] . ' añadido']);
        } else {
            return redirect()->route('welcome_user')->withErrors(['error' => 'no se pudo añadir el producto' . $product['name']]);
        }
    }

    public function deleteOrder($id)
    {
        $url = env('URL_SERVER_API');
        // Accede a la clave "data" del array asociativo
        $response = Http::get($url . '/v1/item_orders/' . $id);
        $item_order = $response->json()["data"];


        if ($item_order['image'] && $item_order['image'] != 'default.svg' && File::exists(public_path('storage/itemOrders/' . $item_order['image']))) {
            File::delete(public_path('storage/itemOrders/' . $item_order['image']));
        }

        $response = Http::delete($url . '/v1/item_orders/' . $id);

        if ($response->successful()) {
            return redirect()->route('getOrders')->with(['success' => 'producto quitado']);
        } else {
            return redirect()->route('getOrders')->withErrors(['error' => 'no se pudo quitar el producto']);
        }
    }
}
