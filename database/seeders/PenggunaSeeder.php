<?php

namespace Database\Seeders;

use App\Models\PenggunaModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PenggunaModel::query()->create([
            'nama_lengkap' => 'Muhammad Rievaldi',
            'email' => 'mrievaldrp6@gmail.com',
            'password' => Hash::make('admin'),
            'no_hp' => '081347682973',
            'alamat' => 'Jalan Komodor Yos Sudarso',
            'kota'  => 'Cibaduyut',
            'jenis_pengguna' => 'Penjemput',
            
        ]);
    }
}