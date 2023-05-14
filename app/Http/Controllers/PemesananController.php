<?php

namespace App\Http\Controllers;

use App\Models\WargaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Warga;

class PemesananController extends Controller
{
    public function store(){
        $fields = [
            'tanggal_penjemputan', 'jam_penjemputan', 'alamat', 'lokasi', 'kota', 'nama_pemesan'
        ];

        $data = [];
        foreach($fields as $f){
            $data[$f] = request($f);
        }

        $data['pengguna_id'] = request()->user()->id;

        $r = WargaModel::query()->create($data);
        return response()->json([
            'data' => $r
        ]);
    }

    public function update(WargaModel $w){
        $w->tanggal_penjemputan = request('tanggal_penjemputan');
        $w->jam_penjemputan = request('jam_penjemputan');
        $w->alamat = request('alamat');
        $w->lokasi = request('lokasi');
        $w->kota = request('kota');
        $w->nama_pemesan = request('nama_pemesan');
        $w->status = request('status');
        $r = $w->save();

        return response()->json([
            'data' => $w
        ], $r == true? 200 : 406);
    }

    public function delete(WargaModel $w){
        return response()->json([
            'data' => $w->delete()
        ]);
    }

    public function simpan_photo(){
        $id = request()->id;
        $p = WargaModel::query()->where('id', $id)->first();

        if($p == null){
            return response()->json(['pesan'=>'Pesanan tidak terdaftar'], 404);
        }

        $b64foto = request('file_foto');

        if(strlen($b64foto) < 1923){
            return response()->json(['pesan'=>'file foto kurang ukurannya'], 406);
        }

        $foto = base64_decode($b64foto);
        $r = Storage::put("foto/$id.jpg", $foto);

        return response()->json([
            'data' => $r
        ], $r == true ? 200 : 406);
    }

    public function show(WargaModel $w){
        return response()->json([
            'data' => $w
        ]);
    }
}
