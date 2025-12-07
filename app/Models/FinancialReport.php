<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    /**
     * Get the items for the financial report.
     */
    public function items()
    {
        return $this->hasMany(FinancialReportItem::class);
    }
}
