<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialReport;
use App\Models\FinancialReportItem;

class FinancialReportItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = FinancialReport::all();

        foreach ($reports as $report) {
            // Add some revenue items
            FinancialReportItem::create([
                'financial_report_id' => $report->id,
                'description' => 'Room Bookings',
                'type' => 'revenue',
                'amount' => rand(5000, 15000),
            ]);

            FinancialReportItem::create([
                'financial_report_id' => $report->id,
                'description' => 'Restaurant Sales',
                'type' => 'revenue',
                'amount' => rand(2000, 8000),
            ]);

            // Add some expense items
            FinancialReportItem::create([
                'financial_report_id' => $report->id,
                'description' => 'Staff Salaries',
                'type' => 'expense',
                'amount' => rand(3000, 7000),
            ]);

            FinancialReportItem::create([
                'financial_report_id' => $report->id,
                'description' => 'Utilities',
                'type' => 'expense',
                'amount' => rand(1000, 3000),
            ]);
        }
    }
}
