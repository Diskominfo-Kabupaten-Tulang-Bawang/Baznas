<?php

namespace App\Http\Controllers\Admin;

use App\Services\CampaignService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\SearchService;


class CampaignController extends Controller
{
    protected $campaignService;
    protected $searchService;

    public function __construct(
        CampaignService $campaignService,
        SearchService $searchService
    ){
        $this->campaignService = $campaignService;
        $this->searchService = $searchService;
    }

    public function index(Request $request, SearchService $searchService)
    {
        $keyword = $request->input('search');

        if ($keyword) {
            $campaigns = $searchService->search(\App\Models\Campaign::class, $keyword, ['title', 'description']);
        } else {
            $this->campaignService->getPaginate(10);
        }

        $campaigns = $this->campaignService->getPaginate(10);

        if ($request->ajax()) {
            return view('admin.campaign._data_table', compact('campaigns'));
        }

        return view('admin.campaign.index', compact('campaigns'));
    }


    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.campaign.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image'           => 'required|image|mimes:png,jpg,jpeg',
            'title'           => 'required',
            'category_id'     => 'required',
            'target_donation' => 'required|numeric',
            'max_date'        => 'required|date',
            'description'     => 'required'
        ]);

        $campaign = $this->campaignService->createCampaign($validated + ['image' => $request->file('image')]);

        return response()->json([
            'status' => $campaign ? 'success' : 'error',
            'message' => $campaign ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!'
        ]);
    }

    public function edit($id)
    {
        $campaign = $this->campaignService->find($id);
        $categories = Category::latest()->get();
        return view('admin.campaign.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'           => 'required',
            'category_id'     => 'required',
            'target_donation' => 'required|numeric',
            'max_date'        => 'required|date',
            'description'     => 'required'
        ]);

        $updated = $this->campaignService->updateCampaign($id, $validated + ['image' => $request->file('image')]);

        return response()->json([
            'status' => $updated ? 'success' : 'error',
            'message' => $updated ? 'Data Berhasil Diupdate!' : 'Data Gagal Diupdate!'
        ]);
    }

    public function destroy($id)
    {
        $deleted = $this->campaignService->deleteCampaign($id);

        return response()->json(['status' => $deleted ? 'success' : 'error']);
    }
}
