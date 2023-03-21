<?php

namespace App\Http\Controllers;

use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CryptoController extends Controller
{
    public function index(CryptoService $userService)
    {
        dd($userService->getAllCryptoData());
    }
    public function index2(CryptoService $userService)
    {
        dd($userService->fillCryptoDataTable());
    }
}
