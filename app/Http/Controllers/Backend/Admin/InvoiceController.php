<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $invoices = Invoice::query();

            return DataTables::of($invoices)
                ->addColumn('invoiceable', function ($invoice) {
                    return optional($invoice->invoiceable)->name . ' (' . class_basename($invoice->invoiceable) . ')';
                })
                ->addColumn('action', function ($invoice) {
                    $edit_btn = '<a href="'. route('admin.invoice.edit', $invoice->id) .'" class="btn btn-sm btn-warning m-2"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $info_btn = '<a href="'. route('admin.invoice.show', $invoice->id) .'" class="btn btn-sm btn-primary m-2"><i class="fa-solid fa-circle-info"></i></a>';
                    $invoice_download_btn = '<a href="'. route('admin.invoice.show', $invoice->id) .'" class="btn btn-sm btn-dark m-2"><i class="fa-solid fa-download"></i></a>';
                    $delete_btn = '<a href="#" class="btn btn-sm btn-danger m-2 delete-btn" data-delete-url="' . route('admin.invoice.destroy', $invoice->id) . '"><i class="fa-solid fa-trash"></i></a>';

                    return '<div class="flex justify-evenly">
                        ' . $edit_btn . $info_btn . $invoice_download_btn . $delete_btn . '
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.admin.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = Invoice::with(['order' => function($query) {
            $query->with(['order_items' => function($q) {
                $q->with('product');
            }]);
        }])->find($invoice->id);

        return view('backend.admin.invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
