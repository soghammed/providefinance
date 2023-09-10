<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'products' => 'required',
            'total_amount' => 'required|numeric',
        ]);

        $user = auth()->user;
        $order = false;

        //create order
        $order = Order::create($request->all());

        //attach products to order;
        $order->products()->sync($request->get('products'));

        //record payment
        $payment = Payment::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'amount' => $request->get('total_amount'),
            'status' => array_rand(['successful', 'failed']),
        ]);
        

        return response()->json([
            'message' => $order ? "Thank you for placing an order, you should receive a confirmation email shortly." : "Error occurred while placing order",
            "status" => $order ? 200 : 500
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
