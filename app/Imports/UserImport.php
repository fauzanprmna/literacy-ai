<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserImport
{
    public function importDosen(array $rows): array
    {
        $success = 0;
        $errors = [];

        foreach ($rows as $index => $row) {

            try {

                DB::beginTransaction();

                // Normalisasi header
                $row = array_change_key_case($row, CASE_LOWER);
                // var_dump($row);exit;

                $nidn = trim($row['nidn'] ?? '');
                $nuptk = trim($row['nuptk'] ?? '');
                $namaLengkap = trim($row['nama dosen'] ?? '');
                $prodi = trim($row['prodi'] ?? '');

                // Validasi
                if (empty($namaLengkap)) {
                    throw new \Exception('Nama dosen wajib diisi');
                }

                // if (empty($nidn) && empty($nuptk)) {
                //     throw new \Exception(
                //         'NIDN atau NUPTK wajib diisi'
                //     );
                // }

                // Nomor induk
                $nomorInduk = !empty($nidn)
                    ? $nidn
                    : $nuptk;

                if (
                    User::where(
                        'nomor_induk',
                        $nomorInduk
                    )->exists()
                ) {
                    throw new \Exception(
                        "Nomor induk {$nomorInduk} sudah terdaftar"
                    );
                }

                // Ambil nama tanpa gelar
                $nama = trim(
                    explode(',', $namaLengkap)[0]
                );

                // Generate email
                $email = $this->generateEmail($nama);

                // Buat User
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'nomor_induk' => $nomorInduk,
                    'role' => 'dosen',
                    'language' => 'id',
                    'password' => Hash::make(
                        'password123'
                    ),
                ]);

                // Buat profil dosen
                Dosen::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $namaLengkap,
                    'nidn' => $nidn ?: null,
                    'nuptk' => $nuptk ?: null,
                    'prodi' => $prodi ?: null,
                ]);

                DB::commit();

                $success++;
            } catch (\Throwable $e) {

                DB::rollBack();

                $errors[] =
                    'Baris ' .
                    ($index + 2) .
                    ': ' .
                    $e->getMessage();
            }
        }

        return [
            'success' => $success,
            'errors' => $errors,
        ];
    }

    /**
     * Generate email dari nama dosen
     * Contoh:
     * ANNISA NUR HASANAH, M.A.
     * =>
     * annisa.nur.hasanah@kampus.ac.id
     */
    private function generateEmail(string $nama): string
    {
        $email = strtolower($nama);

        // Hilangkan karakter selain huruf dan spasi
        $email = preg_replace(
            '/[^a-zA-Z\s]/',
            '',
            $email
        );

        // Spasi menjadi titik
        $email = preg_replace(
            '/\s+/',
            '.',
            trim($email)
        );

        $baseEmail = $email;

        $email .= '@kampus.ac.id';

        $counter = 1;

        while (
            User::where('email', $email)->exists()
        ) {
            $email =
                $baseEmail .
                $counter .
                '@pnj.ac.id';

            $counter++;
        }

        return $email;
    }
}
