<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\DataTables\ListingsDataTable;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListingsDataTable $dataTable)
    {
        return $dataTable->render('admin.listings.listings');
    }

    public function show(Listing $listing)
    {
    	return view('admin.listings.listing')->with('listing', $listing);
    }

    public function change_status(Listing $listing, Request $request)
    {
        $request->validate([
            'status' => 'required|in:'.Listing::STATUS_ACTIVE.','.Listing::STATUS_INACTIVE,
            'note' => 'max:1000',
        ]);

        $listing->status = $request->status;
        $listing->note = $request->status == Listing::STATUS_ACTIVE ? null : $request->note;

        if($listing->save()){
            return response()->json($listing->status(), 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }
}
