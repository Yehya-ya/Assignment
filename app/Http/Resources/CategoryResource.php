<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'title' =>$this->title,
            'parent_id' =>$this->category_id,
            'sub_categories_count' => $this->when(
                isset($this->sub_categories_count),
                $this->sub_categories_count
            )
        ];
    }
}
