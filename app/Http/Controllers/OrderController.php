<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $service)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OrderCollection(Order::with('client')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            return (new OrderResource($this->service->create($request->validated())))
                ->additional(['message'=> 'Resource successfully created']);
        } catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return new OrderResource(Order::where('uuid' , $uuid)
            ->with('client')
            ->firstOrFail()
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $uuid)
    {
        try {
            return (new OrderResource($this->service->update($request->validated(), $uuid)))
                ->additional(['message'=> 'Resource successfully created']);
        } catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()], $e->getCode());
        }
    }
}
