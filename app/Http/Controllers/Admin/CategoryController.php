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
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Category::class);
        $categories = Category::with('parent')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('create', Category::class);
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
        Gate::authorize('update', $category);
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
        Gate::authorize('delete', $category);
        $action->handle($category);
        return redirect()->route('admin.categories.index')->with('success', 'Categorie succesvol verwijderd (naar prullenbak).');
    }

    public function trash()
    {
        Gate::authorize('viewAny', Category::class);
        $trashedCategories = Category::onlyTrashed()->with('parent')->latest('deleted_at')->paginate(10);
        return view('admin.categories.trash', compact('trashedCategories'));
    }

    public function restore(Category $category, RestoreCategoryAction $action)
    {
        Gate::authorize('restore', $category);
        $action->handle($category);
        return redirect()->route('admin.categories.trash')->with('success', 'Categorie succesvol hersteld.');
    }
}
