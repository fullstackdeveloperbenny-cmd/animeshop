<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Categories\CreateCategoryAction;
use App\Actions\Categories\DeleteCategoryAction;
use App\Actions\Categories\UpdateCategoryAction;
use App\Actions\Categories\RestoreCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::all();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(StoreCategoryRequest $request, CreateCategoryAction $action)
    {
        $action->handle($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Categorie succesvol aangemaakt.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategoryAction $action)
    {
        $action->handle($category, $request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Categorie succesvol bijgewerkt.');
    }

    public function destroy(Category $category, DeleteCategoryAction $action)
    {
        $action->handle($category);
        return redirect()->route('admin.categories.index')->with('success', 'Categorie succesvol verwijderd (naar prullenbak).');
    }

    public function trash()
    {
        $trashedCategories = Category::onlyTrashed()->with('parent')->latest('deleted_at')->paginate(10);
        return view('admin.categories.trash', compact('trashedCategories'));
    }

    public function restore(Category $category, RestoreCategoryAction $action)
    {
        $action->handle($category);
        return redirect()->route('admin.categories.trash')->with('success', 'Categorie succesvol hersteld.');
    }
}
