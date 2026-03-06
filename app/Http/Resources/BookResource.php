<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"=> $this->title,
            "isbn"=> $this->isbn,
            "description"=> $this->description,
            "published_at"=> $this->published_at,
            "total_copies"=> $this->total_copies,
            "available_copies"=> $this->available_copies,
            "is available"=> $this->isAvailable(),
            "cover_image"=> $this->cover_image,
            "price"=> $this->price,
            "genera"=> $this->genera,
            "author"=> new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
