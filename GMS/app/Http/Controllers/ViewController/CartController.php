<?php

namespace App\Http\Controllers\ViewController;

use App\TyresProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{


    public function show()
    {
        $cart = session('cart', []); // Retrieve cart from session
        $cartItems = [];
        $total = 0;

        // Check if the cart is empty
        if (empty($cart)) {
            $message = 'No items added to the cart.';
        } else {
            foreach ($cart as $item) {
                if (is_array($item) && isset($item['id'], $item['quantity'])) {
                    $product = TyresProduct::find($item['id']);
                    if ($product) {
                        $cartItems[] = [
                            'product_id' => $product->product_id,
                            'desc' => $product->description,
                            'price' => $product->price,
                            'quantity' => $item['quantity'],
                            'total' => $product->price * $item['quantity'],
                        ];
                        $total += $product->price * $item['quantity'];
                    }
                }
            }
            $message = null;
        }

        return view('view.checkout', compact('cartItems', 'total', 'message'));
    }

    // public function fetchCartItems()
    // {
    //     $cartItems = Session::get('cart', []); // Retrieve cart from session
    //     if (empty($cartItems)) {
    //         return response()->json(['success' => false, 'error' => 'No cart items found in session.'], 404);
    //     }

    //     return response()->json(['success' => true, 'cart_items' => $cartItems], 200);
    // }


    public function add(Request $request)
    {
        $tyreId = $request->input('id');
        $tyre = TyresProduct::find($tyreId);

        if (!$tyre) {
            return response()->json(['success' => false, 'message' => 'Tyre not found'], 404);
        }

        $cart = Session::get('cart', []);
        if (isset($cart[$tyreId])) {
            $cart[$tyreId]['quantity'] += 1;
        } else {
            $cart[$tyreId] = [
                'id' => $tyre->product_id,
                'ean' => $tyre->ean,
                'sku' => $tyre->sku,
                'desc' => $tyre->description,
                'price' => $tyre->price,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['success' => true, 'message' => 'Tyre added to cart']);
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->id;
        $action = $request->action;

        // Loop through the cart items and find the item by ID
        foreach ($cart as &$item) {
            if ($item['id'] == $productId) {
                // Handle increment and decrement actions
                if ($action == 'increase') {
                    $item['quantity']++;
                } elseif ($action == 'decrease' && $item['quantity'] > 1) {
                    $item['quantity']--;
                }

                // Update the total price for this item
                $item['total'] = $item['price'] * $item['quantity'];
                break;
            }
        }

        // Save the updated cart back to the session
        session(['cart' => $cart]);

        // Return a success response
        return response()->json(['success' => true]);
    }


    public function delete(Request $request)
    {

        $productId = $request->input('id');

        if (session()->has('cart')) {
            $cart = session('cart');

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session(['cart' => $cart]);

                return response()->json(['success' => true, 'message' => 'Item removed successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Cart is empty']);
    }




}
