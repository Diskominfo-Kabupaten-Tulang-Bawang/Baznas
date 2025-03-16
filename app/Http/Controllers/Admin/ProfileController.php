<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Menampilkan halaman profil admin.
     *
     * @return View
     */
    public function index(): View
    {
        $user = $this->userService->find(Auth::id());

        return view('admin.profile.index', compact('user'));
    }
}
