<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new CategoryCollection(Category::all()))
            ->additional(['message' => 'Resource successfully completed']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        return (new CategoryResource(Category::create($request->validated())))
            ->additional(['message' => 'Resource successfully created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return (new CategoryResource(Category::findOrFail($category->id)))
            ->additional(['message' => 'Resource successfully completed']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, int $id)
    {
        $response = tap(Category::findOrFail($id))->update($request->validated());
        return (new CategoryResource($response))
            ->additional(['message' => 'Resource successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::findOrFail($category->id)->delete();
        return response()->json([], 204);
    }
}
