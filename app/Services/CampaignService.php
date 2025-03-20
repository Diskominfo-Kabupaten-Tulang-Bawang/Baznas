<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class CampaignService extends BaseService
{
    public function __construct(Campaign $campaign)
    {
        parent::__construct($campaign);
    }

    public function createCampaign($data)
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

        // Buat slug dari nama program
        $data['slug'] = Str::slug($data['title'], '-');

        $data['user_id'] = auth()->id();

        return $this->store($data);
    }

    public function updateCampaign($id, $data)
    {
        $campaign = $this->find($id);
        if (!$campaign) {
            return false;
        }

        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            // Hapus gambar lama jika ada
            if (!empty($campaign->image)) {
                Storage::disk('s3')->delete('categories/' . $campaign->image);
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

        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        return $this->update($campaign, $data);
    }


    public function deleteCampaign($id)
    {
        $campaign = $this->find($id);
        if ($campaign) {
            Storage::disk('s3')->delete('categories/' . $campaign->image);
            return $this->destroy($id);
        }
        return false;
    }

    public function search($keyword, $perPage = 10)
    {
        return Campaign::where('title', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->paginate($perPage);
    }

}
