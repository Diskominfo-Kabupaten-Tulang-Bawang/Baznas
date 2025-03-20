<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderService extends BaseService
{
    public function __construct(Slider $slider)
    {
        parent::__construct($slider);
    }


    /**
     * Simpan slider baru
     */
    public function store($data)
    {

        if (isset($data['image'])) {
            $image = $data['image'];
                // Ubah ekstensi menjadi lowercase
            $extension = strtolower($image->getClientOriginalExtension());

            // Buat nama file unik dengan timestamp
            $filename = time() . '.' . $extension;
            $imagePath = 'categories/' . $filename;
            Storage::disk('s3')->put($imagePath, file_get_contents($image));
            $data['image'] = $filename;

        }

        $data['link'] = Str::slug($data['link'], '-');

        return parent::store($data);
    }

    /**
     * Perbarui slider
     */
    public function update($slider, $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Hapus gambar lama jika ada
            if (!empty($slider->image)) {
                Storage::disk('s3')->delete('categories/' . $slider->image);
            }

            $image = $data['image'];

            // Ubah ekstensi menjadi lowercase
            $extension = strtolower($image->getClientOriginalExtension());

            // Buat nama file unik dengan timestamp
            $filename = time() . '.' . $extension;
            $imagePath = 'categories/' . $filename;

            // Simpan gambar ke S3
            Storage::disk('s3')->put($imagePath, file_get_contents($image));

            // Simpan hanya nama file ke database
            $data['image'] = $filename;
        } else {
            unset($data['image']); // Jika tidak ada gambar baru, gambar lama tetap digunakan
        }

        $data['link'] = Str::slug($data['link'], '-');

        return parent::update($slider, $data);
    }


    /**
     * Hapus slider
     */
    public function destroy($id)
    {
        $slider = $this->find($id);

        if ($slider) {
            if ($slider->image) {
                Storage::disk('s3')->delete('categories/' . $slider->image);
            }
            return parent::destroy($id);
        }

        return false;
    }

    public function search($keyword, $perPage = 10)
    {
        return Slider::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->paginate($perPage);
    }
}
