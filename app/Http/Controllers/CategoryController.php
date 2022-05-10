<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index() : View
    {
        $allCategories = Category::all();
        $categories = Category::where('category_id', null)->withCount('subCategories')->with('subCategories')->get();

        return view('categories.index', [
            'categories' => $categories,
            'allCategories' => $allCategories
        ]);
    }

    public function store(CategoryRequest $request) : RedirectResponse
    {
        Category::create($request->validated());

        return redirect(route('categories.index'))->with([
            'status' => 'a new category has been added successfully.'
        ]);
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect(route('categories.index'))->with([
            'status' => 'The category has been deleted successfully.'
        ]);
    }
}
