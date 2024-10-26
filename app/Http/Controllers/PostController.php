<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Post;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\PostCollection;

class PostController extends Controller
{
    // agar hanya user yang memiliki token yang dapat mengakses semua method di PostController, kita membuat middleware
    public function __construct(){
        $this->middleware('auth:api'); //untuk memanggil endpoint apapun harus menyertakan tokennya
    }


    //menampilkan seluruh data dari tabel atau model post didatabase menggunakan format json di web
    public function index(){
        // untuk menampilkan seluruh data didalam database
        // $data = Post::all(); // menggunakan eloquent

        // pagination
        // pagination adalah misalnya ada jutaan data, kemudian kita set responsenya hanya menampilkan 5 saja
        // $data = Post::paginate(5); // secara background proses akan melakukan query sebanyak 5 kali untuk menemukan user yg berelasi dengan post tertentu
        // sebenarnya yg terjadi adalah di backgroud proses mereka melakuakn query dari masing-masing data tersebut dan ini akan memberatkan proses
        // agar tidak memberatkan, maka kita bisa melakukannya dengan cara dibawah, agar secara background proses querynya hanya dilakukan sekali saja
        $data = Post::with(["user"])->paginate(5); // "user" didapatkan dari method  public function user(){} pada kelas post (nama metode ini adalah eagerload untuk berelasi didalam eloquent)

        // menampilkan banyak data menggunakan resource collection
        return new PostCollection($data);


        // menampilkan response sebagai tipe data json 
        // 2 parameter(data yang akan dimunculkan, status http yang kita kirimkan 200 = response ok)
        // return response()->json($data, 200);
    }

    // untuk melihat response dari api endpoint kita bisa menggunakan browser
    // 

    //menampilkan satu data tertentu dari kelas post
    public function show($id){
        $data = Post::find($id);

        // custom response untuk data yang tidak ditemukan
        if(is_null($data)){
            return response()->json([
                "message" => "Resource not found!"
            ], 404);
        }

        // return response()->json($data,200);
        return new PostResource($data);
    }


    //create
    public function store(Request $request){     
        // untuk mengumpulkan seluruh data yang dikirimkan oleh user
        $data = $request->all();
           
        // menambahkan validasi beserta responsenya
        // misalnya nama tidak boleh kosong atau ada minimal nilai
        $validator = Validator::make($data, [
            'title' => ['required', 'min:5'] //wajib dan minimal 5 karakter
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ],400);
        }


        

        //proses input data kedalam database
        // $response = Post::create($data);

        // mencari data user dengan api_token yang dikirimkan, dan bisa meakukan relasi juga
        $response = request()->user()->posts()->create($data);


        //apabila proses sudah selesai, kita perlu mengirimkan suatu response
        //developer.mozilla.org terdapat clasifikasi responsenya. 201 means create new resource
        return response()->json($response,201);
    }


    //update
    // untuk menentukan objek mana yang akan diubah, kita akan memafaatkan fitur route model binding
    // yaitu dengan membinding class model dari post tersebut
    // dokumentasi di laravel.com route-model-binding
    public function update(Request $request, Post $post){
    //  karena variabel post sudah meruakan objek dari data yang terpilih,
    //  maka untuk melakukan update langsung saja diisi oleh data dari klien
        $post->update($request->all());
        return response()->json($post,200);
    }


    //delete
    public function destroy(Post $post){
        $post->delete(); // akan otomatis akan menghapus data sesuai dengan primary key yang dikirim oleh klient (menggunakan eloquent)
        return response()->json(null,200);
    }

}
