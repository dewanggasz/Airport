<?php

namespace App\Imports;

use App\Models\Airline;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AirlinesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Validasi dasar: Lewati baris jika nama atau kode iata kosong.
        if (empty($row['nama']) || empty($row['kode_iata'])) {
            return null;
        }

        // Gunakan updateOrCreate untuk menghindari duplikat dan memungkinkan pembaruan.
        // Ia akan mencari maskapai berdasarkan 'iata_code'. Jika ada, akan diperbarui. Jika tidak, akan dibuat.
        return Airline::updateOrCreate(
            ['iata_code' => $row['kode_iata']],
            [
                'name' => $row['nama'],
                // Kolom logo bersifat opsional. Jika kosong di CSV, akan diabaikan.
                'logo' => $row['logo'] ?? null,
            ]
        );
    }
}
