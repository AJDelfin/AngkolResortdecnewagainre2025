<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReportItem extends Model
{
    use HasFactory;

    protected $fillable = ['financial_report_id', 'description', 'type', 'amount'];

    /**
     * Get the financial report that owns the item.
     */
    public function financialReport()
    {
        return $this->belongsTo(FinancialReport::class);
    }
}
