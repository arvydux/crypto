<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CryptoResource;
use App\Models\Crypto;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CryptoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $test = request('search_title');
        $cryptos = Crypto::when($test, function ($query, $test) {
            $query->where('name', "like", "%$test%");
        })->paginate(100);

        return CryptoResource::collection($cryptos);
    }
}
