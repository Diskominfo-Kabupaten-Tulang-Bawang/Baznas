<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }

    /**
     * Menampilkan daftar slider dengan pagination
     */
    public function index()
    {
        if (request()->ajax()) {
            $sliders = $this->sliderService->getPaginate(5);
            return view('admin.slider._data_table', compact('sliders'))->render();
        }

        $sliders = $this->sliderService->getPaginate(5);
        return view('admin.slider.index', compact('sliders'));
    }


    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Menyimpan slider baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'string|max:255'
        ]);

        $this->sliderService->store($data);

        return redirect()->route('admin.slider.index')->with('success', 'Data Berhasil Disimpan!');
    }

    /**
     * Menampilkan halaman edit slider
     */
    public function edit($id)
    {
        $slider = $this->sliderService->find($id);
        if (!$slider) {
            return redirect()->route('admin.slider.index')->with('error', 'Data tidak ditemukan!');
        }

        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Memperbarui slider
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'required|string|max:255'
        ]);

        $slider = $this->sliderService->find($id);
        if (!$slider) {
            return redirect()->route('admin.slider.index')->with('error', 'Data tidak ditemukan!');
        }

        $this->sliderService->update($slider, $data);

        return redirect()->route('admin.slider.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Menghapus slider
     */
    public function destroy($id)
    {
        $deleted = $this->sliderService->destroy($id);

        if (!$deleted) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan!'], 404);
        }

        return response()->json(['status' => 'success']);
    }
}
