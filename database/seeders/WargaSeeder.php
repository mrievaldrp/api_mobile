<?php

namespace Database\Seeders;

use App\Http\Controllers\PemesananController;
use App\Models\WargaModel;
use Illuminate\Database\Seeder;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WargaModel::query()->create([
            'tanggal_penjemputan' => '2023-05-13',
            'jam_penjemputan' => '15:30:45',
            'alamat'    => 'Komodor Yos Sudarso',
            'lokasi'    => '-0.02984970545275237, 109.33662812197348',
            'kota'      => 'Cibaduyut',
            'nama_pemesan' => 'Pengkor',
            'status' => 'baru',
            'pengguna_id' => 1,
        ]);
    }
}
