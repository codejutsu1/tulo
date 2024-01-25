<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier' => $this->id,
            'variationId' => $this->variation_id,
            'plan' => $this->plan,
            'price' => $this->original_price,
            'serviceId' => $this->service_id,
        ];
    }
}
