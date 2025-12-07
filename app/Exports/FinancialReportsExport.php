<?php

namespace App\Exports;

use App\Models\FinancialReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FinancialReportsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FinancialReport::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Report Date',
            'Total Revenue',
            'Total Expenses',
            'Net Profit',
        ];
    }

    /**
     * @param mixed $report
     * @return array
     */
    public function map($report): array
    {
        return [
            $report->id,
            $report->report_date,
            $report->total_revenue,
            $report->total_expenses,
            $report->net_profit,
        ];
    }
}
