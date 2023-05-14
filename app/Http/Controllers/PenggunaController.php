<?php

namespace App\Http\Controllers;

use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    public function login(){
        $email = request('email');
        $password = request('password');
        $remember = request('remember',);
    
        $pengguna = PenggunaModel::where('email', $email)->first();
        
        if (!$pengguna) {
            return response()->json([
                'pesan' => 'Email pengguna tidak terdaftar'
            ], 404);
        }
    
        if (Hash::check($password, $pengguna->password)) {
            $pengguna->token = Storage::random(16);

            if ($remember) {
                $pengguna->remember_token = Storage::random(60);
                session()->put('remember_token', $pengguna->remember_token, 60*24*7);;
            }

            $pengguna->save();
    
            return response()->json([
                'data' => $pengguna
            ]);
        }
    
        return response()->json([
            'pesan' => 'Email dan kata sandi tidak cocok'
        ]);
    }
    public function logout(){
        $id = request()->user()->id;
        $p  = PenggunaModel::query()->where('id' , $id)->first();

        if ($p != null){
            $p->token = null;
            $p->save();
            return response()->json(['data'=>1]);
        }else{
            return response()->json([
                'pesan' => 'Logout tidak berhasil, pengguna tidak tersedia'
            ], 404);
        }
    }

    public function update(){
        $id = request()->user()->id;
        $p = PenggunaModel::query()->where('id', $id)->first();

        if($p == null){
            return response()->json([
                'pesan' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        $p->nama_lengkap = request('nama_lengkap');
        $p->email = request('email');
        $r = $p->save();

        return response()->json([
            'data' => $p
        ], $r == true ? 200 : 406);
    }

    public function simpan_photo(){
        $id = request()->user()->id;
        $p = PenggunaModel::query()->where('id', $id)->first();

        if($p == null){
            return response()->json(['pesan'=>'Pengguna tidak terdaftar'], 404);
        }

        $b64foto = request('file_foto');

        if(strlen($b64foto) < 1023){
            return response()->json(['pesan'=>'file fote kurang ukurannya'], 406);
        }

        $foto = base64_decode($b64foto);
        $r = Storage::put("foto/$id.jpg", $foto);

        return response()->json([
            'data' => $r

        ], $r == true ? 200 : 406);
    }

    public function photo(){
        $id = request()->user()->id;
        $foto = Storage::get("foto/$id.jpg");

        return response()->withHeaders([
            'content-type' => 'image/jpeg'
        ])->setContent($foto)->send();
    }
}

