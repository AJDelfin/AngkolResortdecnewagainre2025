<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index()
    {
        $financialReports = FinancialReport::with('items')->latest()->paginate(10);
        return view('staff.financial-reports.index', compact('financialReports'));
    }

    public function show(FinancialReport $financialReport)
    {
        return view('staff.financial-reports.show', compact('financialReport'));
    }
}
