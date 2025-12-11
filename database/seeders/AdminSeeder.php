<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Administrator',
            'nip' => 'bpkpd',
            'password' => Hash::make('bpkpd24434'),
            'role' => 'admin',
        ]);
    }
}
