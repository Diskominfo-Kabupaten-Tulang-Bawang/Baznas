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
            $imagePath = $data['image']->storeAs('public/sliders', $data['image']->hashName());
            $data['image'] = basename($imagePath);
        }

        return parent::store($data);
    }

    /**
     * Perbarui slider
     */
    public function update($slider, $data)
    {
        if (isset($data['image'])) {
            if ($slider->image) {
                Storage::delete("public/sliders/{$slider->image}");
            }
            $imagePath = $data['image']->storeAs('public/sliders', $data['image']->hashName());
            $data['image'] = basename($imagePath);
        } else {
            unset($data['image']);
        }

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
                Storage::delete("public/sliders/{$slider->image}");
            }
            return parent::destroy($id);
        }

        return false;
    }
}
