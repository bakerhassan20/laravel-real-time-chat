<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\invoices;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $invoices = invoices::where('id',$id)->first();
        $details  = invoices_details::where('id_Invoice',$id)->get();
        $attachments  = invoices_attachments::where('invoice_id',$id)->get();

        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $invoices = invoices_attachments::find($request -> id_file)->delete();
        $files = Storage::disk('public_uploads')->delete($request -> invoice_number .'/' .$request ->file_name );
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }


    public function open_file($invoice_number,$file_name)

    {
       $files = Storage::disk('public_uploads')->get($invoice_number.'/'.$file_name);

       return $files;
    }

    
    public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->download($invoice_number.'/'.$file_name);

        return $contents;
    }


}
