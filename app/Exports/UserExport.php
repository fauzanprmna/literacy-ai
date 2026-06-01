<?php

namespace App\Exports;

use App\Models\User;

class UserExport
{
    public function export(): array
    {
        $rows = [];

        $users = User::with(['dosen', 'mahasiswa'])->get();

        foreach ($users as $user) {
            $row = [
                'name' => $user->name,
                'email' => $user->email,
                'nomor_induk' => $user->nomor_induk,
                'role' => $user->role,
                'language' => $user->language,
            ];

            if ($user->role === 'dosen' && $user->dosen) {
                $row = array_merge($row, [
                    'nama_lengkap' => $user->dosen->nama_lengkap,
                    'nidn' => $user->dosen->nidn,
                    'nuptk' => $user->dosen->nuptk,
                    'prodi' => $user->dosen->prodi,
                    'email_institusi' => $user->dosen->email_institusi,
                    'no_telp' => $user->dosen->no_telp,
                    'alamat' => $user->dosen->alamat,
                    'gelar_akademik' => $user->dosen->gelar_akademik,
                ]);
            }

            if ($user->role === 'mahasiswa' && $user->mahasiswa) {
                $row = array_merge($row, [
                    'nama_lengkap' => $user->mahasiswa->nama_lengkap,
                    'nim' => $user->mahasiswa->nim,
                    'prodi' => $user->mahasiswa->prodi,
                    'semester' => $user->mahasiswa->semester,
                    'tahun_angkatan' => $user->mahasiswa->tahun_angkatan,
                    'no_telp' => $user->mahasiswa->no_telp,
                    'alamat' => $user->mahasiswa->alamat,
                    'nama_wali' => $user->mahasiswa->nama_wali,
                    'no_telp_wali' => $user->mahasiswa->no_telp_wali,
                ]);
            }

            $rows[] = $row;
        }

    public function exportMahasiswa(): array
    {
        $rows = [];

        $users = User::where('role', 'mahasiswa')
            ->with('mahasiswa')
            ->get();

        foreach ($users as $user) {
            $row = [
                'name' => $user->name,
                'email' => $user->email,
                'nomor_induk' => $user->nomor_induk,
                'nama_lengkap' => $user->mahasiswa?->nama_lengkap ?? '',
                'nim' => $user->mahasiswa?->nim ?? '',
                'prodi' => $user->mahasiswa?->prodi ?? '',
                'semester' => $user->mahasiswa?->semester ?? '',
                'tahun_angkatan' => $user->mahasiswa?->tahun_angkatan ?? '',
                'no_telp' => $user->mahasiswa?->no_telp ?? '',
                'alamat' => $user->mahasiswa?->alamat ?? '',
                'nama_wali' => $user->mahasiswa?->nama_wali ?? '',
                'no_telp_wali' => $user->mahasiswa?->no_telp_wali ?? '',
                'language' => $user->language,
            ];

            $rows[] = $row;
        }

        return $rows;
    }

    public function exportDosen(): array
    {
        $rows = [];

        $users = User::where('role', 'dosen')
            ->with('dosen')
            ->get();

        foreach ($users as $user) {
            $row = [
                'name' => $user->name,
                'email' => $user->email,
                'nomor_induk' => $user->nomor_induk,
                'nama_lengkap' => $user->dosen?->nama_lengkap ?? '',
                'nidn' => $user->dosen?->nidn ?? '',
                'nuptk' => $user->dosen?->nuptk ?? '',
                'prodi' => $user->dosen?->prodi ?? '',
                'email_institusi' => $user->dosen?->email_institusi ?? '',
                'no_telp' => $user->dosen?->no_telp ?? '',
                'alamat' => $user->dosen?->alamat ?? '',
                'gelar_akademik' => $user->dosen?->gelar_akademik ?? '',
                'language' => $user->language,
            ];

            $rows[] = $row;
        }

        return $rows;
    }
