<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoachingTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoUser = \App\Models\User::where('email', 'demo@cs2.id')->first();
        if (!$demoUser) {
            return;
        }

        // Leave transactions clean for testing real uploads
    }
}
