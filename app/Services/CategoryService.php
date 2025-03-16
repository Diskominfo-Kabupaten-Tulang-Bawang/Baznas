<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService extends BaseService
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function createCategory($data)
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->storeAs('public/categories', $data['image']->hashName());
            $data['image'] = basename($imagePath);
        }

        $data['slug'] = Str::slug($data['name'], '-');

        return $this->store($data);
    }

    public function updateCategory($id, $data)
    {
        $category = $this->find($id);
        if (!$category) {
            return false;
        }

        // Cek apakah image diinputkan
        if (!empty($data['image'])) {
            // Hapus gambar lama jika ada
            if ($category->image) {
                Storage::delete("public/categories/{$category->image}");
            }
            // Simpan gambar baru
            $imagePath = $data['image']->storeAs('public/categories', $data['image']->hashName());
            $data['image'] = basename($imagePath);
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            unset($data['image']);
        }

        $data['slug'] = Str::slug($data['name'], '-');

        return $category->update($data);
    }

    public function deleteCategory($id)
    {
        $category = $this->find($id);

        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Kategori tidak ditemukan!'], 404);
        }

        // Hapus gambar jika ada
        if (!empty($category->image) && Storage::exists("public/categories/{$category->image}")) {
            Storage::delete("public/categories/{$category->image}");
        }

        // Hapus data kategori dari database
        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil dihapus!']);
    }

    public function getCategoryById($id)
    {
        return $this->find($id);
    }
}
