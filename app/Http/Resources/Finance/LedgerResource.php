<?php

namespace App\Http\Resources\Finance;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LedgerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'source_id' => $this->source_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'description' => $this->description,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
            'is_latest' => $this->when(array_key_exists('is_latest', $this->resource->getAttributes()), $this->is_latest),
            'relation' => [
                'user' => new UserResource($this->whenLoaded('user'))
            ]
        ];
    }
}
