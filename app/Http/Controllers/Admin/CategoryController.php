<?php

namespace App\Http\Controllers\Admin;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::latest()->paginate(10);

        if (request()->ajax()) {
            return response()->json([
                'html' => view('admin.category._data_table', compact('categories'))->render()
            ]);
        }

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name'  => 'required|unique:categories'
        ]);

        $category = $this->categoryService->createCategory($validated + ['image' => $request->file('image')]);

        return response()->json([
            'status' => $category ? 'success' : 'error',
            'message' => $category ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!'
        ]);
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('admin.category.edit', compact('category'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        $updated = $this->categoryService->updateCategory($id, $validated + ['image' => $request->file('image')]);

        return response()->json([
            'status' => $updated ? 'success' : 'error',
            'message' => $updated ? 'Data Berhasil Diupdate!' : 'Data Gagal Diupdate!'
        ]);
    }

    public function destroy($id)
    {
        $deleted = $this->categoryService->deleteCategory($id);

        return response()->json([
            'status' => $deleted ? 'success' : 'error',
            'message' => $deleted ? 'Data Berhasil Dihapus!' : 'Data Gagal Dihapus!'
        ]);
    }

}
