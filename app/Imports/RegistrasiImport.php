<?php
namespace App\Imports;

use App\Models\Registrasi;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegistrasiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $allowedRoles = ['siswa', 'guru', 'Admin', 'Orang Tua', 'Perpustakaan', 'calon_siswa'];

        if (!in_array($row['role_name'], $allowedRoles)) {
            throw new \Exception("Invalid role_name: " . $row['role_name']);
        }

        return new Registrasi([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'role_name' => $row['role_name'],
        ]);
    }
}
