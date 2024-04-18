<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ClientCollection(Client::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        return (new ClientResource(Client::create($request->validated())))
            ->additional(['message'=> 'Resource successfully created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return new ClientResource(Client::where('uuid' , $uuid)->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, string $uuid)
    {
        $client = Client::where('uuid', $uuid)->first();
        if (!$client) throw new NotFoundHttpException;
        $client->update($request->validated());
        $client = $client->refresh();

        return (new ClientResource($client))
            ->additional(['message' => 'Resource successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        if (!Client::where('uuid', $uuid)->delete()) {
            throw new NotFoundHttpException;
        }

        return response()->json([], 204);
    }
}
