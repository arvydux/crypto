<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CryptoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $trasnformetd_to_monet_format = [
            'market_cap'         => '$' . number_format($this->market_cap),
            'volume_24h'         => '$' . number_format($this->volume_24h),
            'circulating_supply' => number_format($this->circulating_supply) . ' '. $this->symbol,
        ];
        return array_merge(parent::toArray($request), $trasnformetd_to_monet_format) ;
    }
}
