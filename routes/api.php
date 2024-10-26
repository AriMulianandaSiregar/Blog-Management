<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//buat sendiri route apinya:

//menggunakan url post dan url post tersebut mengarah pada PostController
//cara penggunaannya 127.0.0.1:8000/api/post
use App\Http\Controllers\PostController;
Route::get('/post', [PostController::class, 'index']);
// Route::get('/post', PostController::class);
// Route::get("/post", "PostController@index");


// untuk mengisi nilai dari parameter id kita bisa menggunakan postman
// Route::get('/post/{id}', [PostController::class, 'show']);
Route::get('/post/{id}', "PostController@show");


// route untuk create -> POST http://127.0.0.1:8000/api/post (datanya didalam body)
// header -> Accept application/json
//        -> Content-Type application/json
Route::post("/post","PostController@store");


// route untuk update -> PUT http://127.0.0.1:8000/api/post/2
// data yang ingin diubah dituliskan didalam body di postman (pilih raw dan json)
// {
//     "id": 2,
//     "user_id": 7,
//     "title": "this is the first update from API",
//     "body": "this is the content of the first updated from API"
// }
Route::put("/post/{post}", "PostController@update");


// route untuk delete -> DELETE http://127.0.0.1:8000/api/post/2
Route::delete("/post/{post}", "PostController@destroy");

// karena pada kali ini kita hanya membangun web service saya dan tidak perlu menggunakan view
// sehingga kita perlu menggunakan software agar dapat mengirimkan data pada proses post
// kita menggunakan tools getpostman.com untuk mengetes api endpoint yang kita buat dengan mendownload software postman


// untuk menggunakan API authentication kita bisa menggunakan API tokens,
// untuk membuatnya:
// 1. menambahkan kolom baru didatabase dengan nama api_token
// php artisan make:migration add_api_token_column_to_users_table
// 2. tambahkan kode pada function up dan down
// 3. tambahkan kode 'api_token' => Str::random(80), pada user factory
// 4. tambahkan bagian generate token pada class registrationController pada method create (tambahkan kode 'api_token' => Str::random(80))
// 5. tambahkan use\Illuminate\Support\str; di registrationController
// 6. lakukan migrate php artisan migrate:refresh --seed

// Bagaimana jika kita ingin mengakses kedalam api postController, yang bisa melakukan hanya user yang sudah memiliki token
// 1. tambahkan kode dibawah pada PostController
// public function __construct(){
//     $this->middleware('auth:api'); //untuk memanggil endpoint apapun harus menyertakan tokennya
// }
// untuk mengaksesnya didalam postman, buka authorization, pilih Bearer Token, masukan token usernya







