<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::success('', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        return ApiResponse::success('Resource successfully created', Category::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return ApiResponse::success('Resource successfully founded', Category::findOrFail($category->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, int $id)
    {
        $response = tap(Category::findOrFail($id))->update($request->validated());
        return ApiResponse::success('Resource successfully updated', $response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $category)
    {
        Category::findOrFail($category->id)->delete();
        return ApiResponse::success('Resource successfully removed', []);
    }
}
