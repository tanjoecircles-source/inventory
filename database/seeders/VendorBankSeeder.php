<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\VendorBank::insert([
            ['name' => 'Mandiri', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'BSI', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Seabank', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
