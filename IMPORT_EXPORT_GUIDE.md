# User Import/Export CSV Format Guide

## CSV Header Format

The CSV file must have the following header columns:

```
name,email,nomor_induk,role,language,nama_lengkap,password
```

### For Dosen (role = dosen):

```
name,email,nomor_induk,role,language,nama_lengkap,nip,bidang_keahlian,email_institusi,no_telp,alamat,gelar_akademik,password
```

### For Mahasiswa (role = mahasiswa):

```
name,email,nomor_induk,role,language,nama_lengkap,nim,prodi,semester,tahun_angkatan,no_telp,alamat,nama_wali,no_telp_wali,password
```

## Example Data

### Dosen Example:

```csv
name,email,nomor_induk,role,language,nama_lengkap,nip,bidang_keahlian,email_institusi,no_telp,alamat,gelar_akademik,password
Dr. Ahmad Syaiful,ahmad.syaiful@university.ac.id,D001,dosen,id,Dr. Ahmad Syaiful,198505101234567,Ilmu Komputer,ahmad@university.ac.id,08123456789,Jl. Komputer No. 1,S1/S2/S3,password123
```

### Mahasiswa Example:

```csv
name,email,nomor_induk,role,language,nama_lengkap,nim,prodi,semester,tahun_angkatan,no_telp,alamat,nama_wali,no_telp_wali,password
Budi Santoso,budi.santoso@student.ac.id,M001,mahasiswa,id,Budi Santoso,21001001,Teknik Informatika,5,2021,08987654321,Jl. Mahasiswa No. 5,Bambang Santoso,08111111111,password123
```

## Field Requirements

| Field        | Required | Type   | Description                            |
| ------------ | -------- | ------ | -------------------------------------- |
| name         | Yes      | String | User's display name                    |
| email        | Yes      | String | Unique email address                   |
| nomor_induk  | Yes      | String | Unique identification number           |
| role         | Yes      | String | `dosen`, `mahasiswa`, or `admin`       |
| language     | No       | String | `id` or `en` (default: `id`)           |
| nama_lengkap | No       | String | Full name for profile                  |
| password     | No       | String | User password (default: `password123`) |

### Dosen-specific fields:

- nip: Nomor Induk Pegawai
- bidang_keahlian: Area of expertise
- email_institusi: Institutional email
- no_telp: Phone number
- alamat: Address
- gelar_akademik: Academic degree

### Mahasiswa-specific fields:

- nim: Nomor Induk Mahasiswa
- prodi: Program Studi (Major)
- semester: Current semester
- tahun_angkatan: Academic year
- no_telp: Phone number
- alamat: Address
- nama_wali: Guardian's name
- no_telp_wali: Guardian's phone

## Import Process

1. Go to `/users/import`
2. Select CSV file
3. Click "Import"
4. View results with success/error messages

## Export Process

1. Go to `/users/import`
2. Click "Export Users" button
3. CSV file will be downloaded with all current users

## Error Handling

- Duplicate emails or nomor_induk will be rejected
- Missing required fields will be reported
- Invalid email format will be detected
- Invalid role values will be rejected
- All errors are logged with row numbers for easy fixing
