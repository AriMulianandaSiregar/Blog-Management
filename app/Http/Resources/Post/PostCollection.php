<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\ResourceCollection;

// php artisan make:resource Post\PostCollection

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // "data" => $this->collection = untuk mendapatkan semua datanya
            "data" => PostResource::collection($this->collection), // untuk memilah dan memodifikasi data-datanya dengan memanfaatkan PostResource
            
            //bisa juga kita menambahkan data  dengan memanfaatkan query collection dalam eloquent
            "meta" => [
                "total_post" => $this->collection->count()
            ]
        
        ];
    }
}

