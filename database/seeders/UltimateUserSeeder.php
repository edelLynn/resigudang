<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UltimateUserSeeder extends Seeder
{
    public function run()
    {
        // 1. AKUN BOS PT (SUPER ADMIN)
        User::create([
            'name' => 'Bapak CEO PT',
            'email' => 'admin.pt@resigudang.com',
            'password' => Hash::make('pw123'),
            'role' => 'admin_pt',
            'status' => 'active',
        ]);

        // 2. AKUN ADMIN KOPERASI (ADMIN LAPANGAN)
        User::create([
            'name' => 'Admin Koperasi Unit 1',
            'email' => 'admin.kop@resigudang.com',
            'password' => Hash::make('pw321'),
            'role' => 'admin_koperasi',
            'status' => 'active',
        ]);

        // 3. AKUN PETANI (CONTOH)
        User::create([
            'name' => 'Pak Tani Sukses',
            'email' => 'petani@resigudang.com',
            'password' => Hash::make('pw354'),
            'role' => 'petani',
            'status' => 'active',
        ]);
    }
}