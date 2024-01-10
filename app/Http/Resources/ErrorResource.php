<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
     /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'errors';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => false,
            'message' => 'Error Occuerred',
            'errors' => parent::toArray($request),
        ];
    }
}
