<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(5);
        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/sliders', $image->hashName());

        //save to DB
        $slider = Slider::create([
            'image'  => $image->hashName(),
            'link'   => $request->link
        ]);

        if($slider){
             //redirect dengan pesan sukses
             return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Disimpan!']);
         }else{
             //redirect dengan pesan error
             return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Disimpan!']);
         }
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return void
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,jpg,png|max:2000',
            'link'  => 'required'
        ]);

        $slider = Slider::findOrFail($id);

        if ($request->hasFile('image')) {
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/sliders', $image->hashName());

            //delete old image
            Storage::disk('local')->delete('public/sliders/'.basename($slider->image));

            //update slider with new image
            $slider->update([
                'image' => $image->hashName(),
                'link'  => $request->link
            ]);
        } else {
            //update slider without image
            $slider->update([
                'link' => $request->link
            ]);
        }

        if($slider){
            //redirect dengan pesan sukses
            return redirect()->route('admin.slider.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.slider.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        Storage::disk('local')->delete('public/sliders/'.basename($slider->image));
        $slider->delete();

        if($slider){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
