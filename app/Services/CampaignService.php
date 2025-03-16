<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignService extends BaseService
{
    public function __construct(Campaign $campaign)
    {
        parent::__construct($campaign);
    }

    public function createCampaign($data)
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->storeAs('public/campaigns', $data['image']->hashName());
            $data['image'] = basename($imagePath);
        }

        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        return $this->store($data);
    }

    public function updateCampaign($id, $data)
    {
        $campaign = $this->find($id);
        if (!$campaign) {
            return false;
        }

        if (!empty($data['image'])) {
            Storage::delete("public/campaigns/{$campaign->image}");
            $imagePath = $data['image']->storeAs('public/campaigns', $data['image']->hashName());
            $data['image'] = basename($imagePath);
        } else {
            unset($data['image']);
        }

        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        return $this->update($campaign, $data);
    }


    public function deleteCampaign($id)
    {
        $campaign = $this->find($id);
        if ($campaign) {
            Storage::delete("public/campaigns/{$campaign->image}");
            return $this->destroy($id);
        }
        return false;
    }
}
