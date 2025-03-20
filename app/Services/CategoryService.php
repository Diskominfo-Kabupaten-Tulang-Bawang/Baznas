<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class CategoryService extends BaseService
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function createCategory($data)
    {
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $image = $data['image'];

            // Ubah ekstensi menjadi lowercase
            $extension = strtolower($image->getClientOriginalExtension());

            // Buat nama file unik dengan UUID
            $filename = Str::uuid() . '.' . $extension;
            $imagePath = 'categories/' . $filename;

            // Simpan gambar ke S3
            Storage::disk('s3')->put($imagePath, file_get_contents($image));

            // Simpan hanya nama file ke database
            $data['image'] = $filename;
        }

        // Buat slug dari nama kategori
        $data['slug'] = Str::slug($data['name'], '-');

        return $this->store($data);
    }

    public function updateCategory($id, $data)
    {
        $category = $this->find($id);
        if (!$category) {
            return false;
        }

        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            // Hapus gambar lama jika ada
            if (!empty($category->image)) {
                Storage::disk('s3')->delete('categories/' . $category->image);
            }

            // Ubah ekstensi menjadi lowercase
            $extension = strtolower($data['image']->getClientOriginalExtension());

            // Buat nama file unik dengan UUID
            $filename = Str::uuid() . '.' . $extension;
            $imagePath = 'categories/' . $filename;

            // Simpan file ke S3
            Storage::disk('s3')->put($imagePath, file_get_contents($data['image']));

            // Simpan nama file baru ke database
            $data['image'] = $filename;
        } else {
            unset($data['image']); // Jangan ubah jika tidak ada gambar baru
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
        if (!empty($category->image)) {
            Storage::disk('s3')->delete('categories/' . $category->image);
        }

        $category->delete();

        return response()->json(['status' => 'success', 'message' => 'Kategori berhasil dihapus!']);
    }

    public function getCategoryById($id)
    {
        return $this->find($id);
    }

    public function search($keyword, $perPage = 10)
    {
        return Category::where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->paginate($perPage);
    }
}
