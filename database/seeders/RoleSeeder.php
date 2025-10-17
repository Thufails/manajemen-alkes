<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan sementara foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel roles
        DB::table('roles')->truncate();

        // Isi data role
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'kasir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
