<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index() : View
    {
        $categories = Category::all();

        return view('welcome');
    }

    public function create()
    {
        return view('welcome');
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return view('welcome');
    }


    public function edit(Category $category)
    {
        return view('welcome');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return view('welcome');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return view('welcome');
    }
}
