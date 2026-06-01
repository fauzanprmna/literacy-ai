@extends('template.template-admin')

@section('title', 'Import Mahasiswa')
@section('header', 'Import Mahasiswa')

@push('head')
    <style>

        .import-section {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 28px;
            margin-bottom: 20px;
        }

        .import-section h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 16px;
        }

        .import-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 8px;
            display: block;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            border: 2px dashed var(--gray-300);
            border-radius: var(--radius-md);
            background: var(--gray-50);
            cursor: pointer;
            transition: all .2s;
        }

        .file-input-label:hover {
            border-color: var(--green-400);
            background: var(--green-50);
        }

        .file-input-label i {
            font-size: 24px;
            color: var(--green-600);
            margin-right: 12px;
        }

        .file-input-label-text {
            text-align: left;
        }

        .file-input-label-text p {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .file-input-label-text small {
            display: block;
            font-size: 11px;
            color: var(--gray-400);
            margin-top: 4px;
        }

        .btn-import {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 11px 28px;
            background: var(--green-700);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-import:hover {
            background: var(--green-600);
            transform: translateY(-1px);
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 11px 28px;
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .btn-export:hover {
            background: var(--gray-200);
        }

        .import-result {
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
        }

        .import-result.success {
            background: var(--green-50);
            border: 1px solid var(--green-100);
            color: var(--green-800);
        }

        .import-result.error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .import-result h4 {
            margin: 0 0 8px 0;
            font-size: 13px;
            font-weight: 700;
        }

        .import-result ul {
            margin: 0;
            padding-left: 20px;
            font-size: 12px;
        }

        .import-result li {
            margin-bottom: 4px;
        }

        .template-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            background: #ede9fe;
            color: #5b21b6;
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all .15s;
        }

        .template-link:hover {
            background: #ddd6fe;
        }
    </style>
@endpush

@section('content')
    <div class="import-container">
        @if (session('import_result'))
            @php
                $result = session('import_result');
                $hasErrors = !empty($result['errors']);
            @endphp
            <div class="import-result {{ $hasErrors ? 'error' : 'success' }}">
                <h4>
                    @if ($hasErrors)
                        <i class="bi bi-exclamation-circle"></i> Import Selesai dengan Beberapa Kesalahan
                    @else
                        <i class="bi bi-check-circle"></i> Import Berhasil
                    @endif
                </h4>
                <p style="margin: 8px 0 0 0;">Total berhasil: <strong>{{ $result['success'] ?? 0 }}</strong> data</p>
                @if ($hasErrors)
                    <ul>
                        @foreach ($result['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        <!-- Import Section -->
        <div class="import-section">
            <h3><i class="bi bi-upload" style="margin-right: 8px;"></i> Import Mahasiswa</h3>

            <form action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="file-input-wrapper">
                    <input type="file" name="file" class="file-input" id="fileInput" accept=".csv,.xlsx,.xls"
                        required>
                    <label for="fileInput" class="file-input-label">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <div class="file-input-label-text">
                            <p>Pilih file atau drag & drop</p>
                            <small>Format: CSV atau Excel (Max 5MB)</small>
                        </div>
                    </label>
                </div>

                <div style="margin-top: 20px; display: flex; gap: 12px; align-items: center;">
                    <button type="submit" class="btn-import">
                        <i class="bi bi-upload"></i> Import Data
                    </button>
                    <a href="{{ route('mahasiswa.export') }}" class="template-link" download>
                        <i class="bi bi-download"></i> Download Template
                    </a>
                </div>
            </form>
        </div>

        <!-- Instructions -->
        <div class="import-section" style="background: var(--gray-50);">
            <h3><i class="bi bi-info-circle" style="margin-right: 8px;"></i> Format File CSV</h3>
            <p style="color: var(--gray-600); font-size: 13px; margin-bottom: 12px;">
                File CSV harus memiliki kolom-kolom berikut dengan urutan yang benar:
            </p>
            <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--white);">
                        <th style="padding: 8px; text-align: left; border-bottom: 1px solid var(--gray-200);">Kolom</th>
                        <th style="padding: 8px; text-align: left; border-bottom: 1px solid var(--gray-200);">Tipe</th>
                        <th style="padding: 8px; text-align: left; border-bottom: 1px solid var(--gray-200);">Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">name *</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Nama user untuk login</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">email *</td>
                        <td style="padding: 8px;">Email</td>
                        <td style="padding: 8px;">Email unik untuk login</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">nomor_induk *</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">NIM (Nomor Induk Mahasiswa)</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">nama_lengkap *</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Nama lengkap mahasiswa</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">nim</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Nomor Induk Mahasiswa (opsional)</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">prodi</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Program Studi</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">semester</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Semester saat ini</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">tahun_angkatan</td>
                        <td style="padding: 8px;">Year</td>
                        <td style="padding: 8px;">Tahun angkatan masuk</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">no_telp</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Nomor telepon</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">alamat</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Alamat rumah</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">nama_wali</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Nama wali/orang tua</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">no_telp_wali</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Nomor telepon wali</td>
                    </tr>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 8px;">password</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">Default: password123</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px;">language</td>
                        <td style="padding: 8px;">Text</td>
                        <td style="padding: 8px;">id atau en (default: id)</td>
                    </tr>
                </tbody>
            </table>
            <p style="color: var(--gray-400); font-size: 11px; margin-top: 12px; margin-bottom: 0;">
                * = Kolom wajib diisi
            </p>
        </div>
    </div>
@endsection
