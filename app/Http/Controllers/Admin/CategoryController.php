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

        if (request()->ajax() && request()->get('load') == 'table') {
            return view('admin.category._data_table', compact('categories'))->render();
        }

        return view('admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name'  => 'required|unique:categories,name'
        ]);

        $category = $this->categoryService->createCategory([
            'name' => $validated['name'],
            'image' => $request->file('image')
        ]);

        // dd($category);

        return response()->json([
            'status' => $category ? 'success' : 'error',
            'message' => $category ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!'
        ]);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2000'
        ]);

        $data = ['name' => $validated['name']];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $updated = $this->categoryService->updateCategory($id, $data);

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
