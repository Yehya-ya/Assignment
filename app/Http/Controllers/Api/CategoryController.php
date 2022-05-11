<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller {

    public function all() : AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }

    public function index() : AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::where('category_id', null)->withCount('subCategories')->get());
    }

    public function show(Category $category) : AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::where('category_id', $category->id)->withCount('subCategories')->get());
    }

    public function store(CategoryRequest $request) : JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json([
            'data' => CategoryResource::make($category),
            'message' => 'a new category has been added successfully.'
        ], Response::HTTP_CREATED);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'data' => CategoryResource::make($category),
            'message' => 'the category has been deleted successfully.'
        ], Response::HTTP_OK);
    }
}
