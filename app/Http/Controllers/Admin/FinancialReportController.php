<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    public function index()
    {
        $financialReports = FinancialReport::with('items')->latest()->paginate(10);
        return view('admin.financial-reports.index', compact('financialReports'));
    }

    public function create()
    {
        return view('admin.financial-reports.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'report_date' => 'required|date',
            'items' => 'sometimes|array',
            'items.*.description' => 'required|string|max:255',
            'items.*.type' => 'required|in:revenue,expense',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $financialReport = FinancialReport::create([
                'title' => $validatedData['title'],
                'report_date' => $validatedData['report_date'],
            ]);

            if (isset($validatedData['items'])) {
                foreach ($validatedData['items'] as $item) {
                    $financialReport->items()->create($item);
                }
            }

            DB::commit();

            return redirect()->route('admin.financial-reports.index')->with('success', 'Financial report created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create financial report. Please try again.')->withInput();
        }
    }

    public function show(FinancialReport $financialReport)
    {
        return view('admin.financial-reports.show', compact('financialReport'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(FinancialReport $financialReport)
    {
        $financialReport->delete();

        return redirect()->route('admin.financial-reports.index')->with('success', 'Financial report deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        FinancialReport::destroy($request->ids);

        return redirect()->route('admin.financial-reports.index')->with('success', 'Financial reports deleted successfully.');
    }
}
