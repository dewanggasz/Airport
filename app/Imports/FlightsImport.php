<?php

namespace App\Imports;

use App\Models\Flight;
use App\Models\Airline;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class FlightsImport implements ToCollection, WithHeadingRow
{
    // Properti untuk menyimpan hasil impor
    public int $importedRows = 0;
    public array $failedRows = [];

    public function collection(Collection $rows)
    {
        // Ambil semua maskapai sekali saja untuk efisiensi
        $airlines = Airline::pluck('id', 'iata_code');

        foreach ($rows as $rowIndex => $row) 
        {
            // Validasi data penting
            if (empty($row['no_penerbangan']) || empty($row['kode_maskapai'])) {
                $this->failedRows[] = ['row' => $rowIndex + 2, 'reason' => 'Kolom no_penerbangan atau kode_maskapai kosong.'];
                continue; // Lanjut ke baris berikutnya
            }

            // Cari ID maskapai
            $airlineId = $airlines->get($row['kode_maskapai']);
            
            if (!$airlineId) {
                $this->failedRows[] = ['row' => $rowIndex + 2, 'reason' => 'Kode maskapai "' . $row['kode_maskapai'] . '" tidak ditemukan di database.'];
                continue; // Lanjut ke baris berikutnya
            }

            // Coba buat atau perbarui data
            try {
                Flight::create([
                    'flight_number'  => $row['no_penerbangan'],
                    'airline_id'     => $airlineId,
                    'direction'      => strtolower($row['arah']),
                    'city'           => $row['kota'],
                    'status'         => $row['status'],
                    // Konversi manual tanggal dari angka Excel
                    'scheduled_time' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['waktu_jadwal']),
                ]);

                $this->importedRows++; // Tambah hitungan sukses

            } catch (\Exception $e) {
                $this->failedRows[] = ['row' => $rowIndex + 2, 'reason' => 'Error data: ' . $e->getMessage()];
                Log::error("Gagal mengimpor baris: " . json_encode($row) . " | Error: " . $e->getMessage());
            }
        }
    }
}
