<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;
// php artisan make:resource Post\PostResource

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // memanipulasi data apasaja yang ingin ditampilkan saat meminta request
        // keyword this is coming from show method in PostController
        return [
            "title" => $this->title,
            "body" => $this->body,
            "stored_at" => $this->created_at->diffForHumans(),
            
            // memuat data berelasi di API Resource
            // "user" => $this->user
            //hasilnya dalam postman
            // "data": {
            //     "title": "Pariatur est eum perspiciatis dolores consequatur aperiam.",
            //     "body": "Quo soluta et sequi quas voluptatibus. Minus et dolores porro et vel eligendi. Architecto nesciunt et ratione.",
            //     "stored_at": "6 days ago",
            //     "user": {
            //         "id": 10,
            //         "name": "Mrs. Deanna Kiehn",
            //         "email": "Jerald.Breitenberg@example.org",
            //         "email_verified_at": "2024-08-05 07:19:14",
            //         "created_at": "2024-08-05 07:19:14",
            //         "updated_at": "2024-08-05 07:19:14"
            //     }
            // }
            // namun agar lebih rapi, kita bisa membuat kelas resource untuk user sendiri
            // 1. php artisan make:resource User/UserResource
            // panggil seperti dibawah
            "user" => new UserResource($this->user)
            //sehingga hasilnya seperti ini
            // "data": {
            //     "title": "Pariatur est eum perspiciatis dolores consequatur aperiam.",
            //     "body": "Quo soluta et sequi quas voluptatibus. Minus et dolores porro et vel eligendi. Architecto nesciunt et ratione.",
            //     "stored_at": "6 days ago",
            //     "user": {
            //         "name": "Mrs. Deanna Kiehn",
            //         "email": "Jerald.Breitenberg@example.org"
            //     }
            // }
            // sebenarnya yg terjadi adalah di backgroud proses mereka melakuakn query dari masing-masing data tersebut dan ini akan memberatkan proses
             
            
            
        ];
    }
}
