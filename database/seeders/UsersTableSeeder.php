<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert default tim_kerja
        $timKerjaId = DB::table('tim_kerja')->insertGetId([
            'nama' => 'tatausaha',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Ganti dengan password yang aman
                'role' => 'admin',
                'no_telp' => '081234567890',
                'tim_kerja_id' => $timKerjaId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // Ganti dengan password yang aman
                'role' => 'user',
                'no_telp' => '081234567891',
                'tim_kerja_id' => $timKerjaId, // Jika user juga memiliki tim kerja yang sama
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
