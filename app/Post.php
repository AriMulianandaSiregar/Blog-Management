<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

// // menyembunyikan data created_at dan updated_at pada saat meminta request
//     protected $hidden = ["created_at", "updated_at"];

// // mengubah tanggal dari data post dibuat kedalam bahasa yang mudah dimengerti saat meminta request
// // berasal dari created_at tetapi kita ubah formatnya
//     protected $appends = ["stored_at"];
//     public function getStoredAtAttribute(){
//         return $this->created_at->diffForHumans();
//     }



    public function user()
    {
        return $this->belongsTo(User::class); // belongsTo maksudnya one to many, satu user bisa memiliki beberapa post
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
