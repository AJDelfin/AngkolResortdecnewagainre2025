<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Invoice;
use App\Models\FinancialReport;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            FinancialReportItemSeeder::class
        ]);

        Invoice::factory(20)->create();
        FinancialReport::factory(10)->create();
    }
}
