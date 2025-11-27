<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update default user to admin if they exist
        DB::table('users')->where('id', 3)->update([
            'role' => 'admin',
            'updated_at' => Carbon::now()
        ]);

        // If there are no users, create default users for each role
        if (DB::table('users')->count() === 0) {
            DB::table('users')->insert([
                [
                    'name' => 'Admin Keuangan',
                    'email' => 'admin@keuangan.test',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Bendahara Utama',
                    'email' => 'bendahara@keuangan.test',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'role' => 'bendahara',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'name' => 'Auditor Keuangan',
                    'email' => 'auditor@keuangan.test',
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make('password'),
                    'role' => 'auditor',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ]);
        } elseif (DB::table('users')->where('role', 'admin')->count() === 0) {
            // Create at least one admin user if none exist
            DB::table('users')->insert([
                'name' => 'Admin Keuangan',
                'email' => 'admin@keuangan.test',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
