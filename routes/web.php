<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use illuminate\Http\Request;
use illuminate\Support\Facades\Log;
use illuminate\Support\Facades\Mail;
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'produk'], function () use ($router) {
    $router->get('/', function () {
        return response()->json([
            [
                "status" => "success",
                "products" => [
                  [
                    "id" => 101,
                    "name" => "Product 1",
                    "description" => "Description of Product 1",
                    "price" => 20000,
                    "stock" => 100
                  ],
                  [
                    "id" => 102,
                    "name" => "Product 2",
                    "description" => "Description of Product 2",
                    "price" => 15000,
                    "stock" => 50
                  ]
                ]
            ]            

        ]);
    });
    $router->get('/orders', function ($id) {
        return response()->json(['data' => [
            [
                "status" => "success",
                "orders" => [
                  [
                    "id" => 202,
                    "total_price" => 55000,
                    "status" => "completed",
                    "created_at" => "2024-10-21"
                  ],
                  [
                    "id" => 203,
                    "total_price" => 30000,
                    "status" => "pending",
                    "created_at" => "2024-10-20"
                  ]
                ]
            ]
              
        ]
            ]);
    });
    $router->get('/orders/{id}', function ($id) {
        return response()->json(['data' => [
            [
                "id" => $id,
                "status" => "success",
                "order" => [
                  "id" => 202,
                  "products" => [
                    [
                      "product_id" => 101,
                      "name" => "Product 1",
                      "quantity" => 2,
                      "price" => 20000
                    ],
                    [
                      "product_id" => 102,
                      "name" => "Product 2",
                      "quantity" => 1,
                      "price" => 15000
                    ]
                  ],
                  "total_price" => 55000,
                  "status" => "completed",
                  "payment_method" => "credit_card",
                  "created_at" => "2024-10-21"
                ]
            ]
              
        ]]);
    });
    
    $router->post('/orders', function(){
        return response()->json([
                "user_id" => 1,
                "products" => [
                  [
                    "product_id" => 101,
                    "quantity" => 2
                  ],
                  [
                    "product_id" => 102,
                    "quantity" => 1
                  ]
                ],
                "total_price" => 55000,
                "payment_id" => 301
        ]);
    });

    $router->put('/{id}', function (Request $request, $id) {
        $nomor = $request->input("nomor");
        return response()->json(['data' => [
                "id" => $id,
                "status" => "success",
                "message" => "Order updated successfully",
                "order" => [
                  "id" => 202,
                  "status" => "shipped",
                  "total_price" => 55000,
                  "payment_method" => "credit_card",
                  "updated_at" => "2024-10-21"
                ]
        ]]);
    });

    $router->delete('/{id}', function ($id) {
        return response()->json(['msg' => [
                "status" => "success",
                "message" => "Order deleted successfully"
              
        ]]);
    });

    $router->get('/{id}/confirm', function (Request $request, $id) {
        $user = $request->user();
        if($user == null){
            return response()->json(['error' => 'Unauthorized'], 401, ['X-Header-One' => 'Header Value']);
        }
        return response()->json(['data' => "berhasil confirm"]);
    });
    $router->get('/{id}/sendemail', function (Request $request, $id) {
        $user = $request->user();
        Mail::raw('email body', function ($message){
            $message->to('mahadewiberliana6@gmail.com')
                ->subject('lumen email test');
        });
        return response()->json(['data' => "berhasil kirim email"]);
    });


});