<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AreasDataTable;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\State;
use Illuminate\Http\Request;
use Str;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(State $state, AreasDataTable $dataTable)
    {
        return $dataTable
                ->render('admin.areas.areas', ['state' => $state]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        $area = new Area;
        $area->name = $request->name;
        $slug = Str::slug($request->name);
        $area->slug = Area::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;
        $area->state_id = $request->state_id;

        if ($area->save()) {
            return response()->json('تم الحفظ بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('admin.areas.edit-area')->with([
            'state' => $area->state,
            'area' => $area,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        $area->name = $request->name;
        $slug = Str::slug($request->name);
        $area->slug = Area::where('slug', $slug)->where('id', '!=', $area->id)->count() ? $slug.'-'.uniqid() : $slug;

        if ($area->save()) {
            return redirect()->route('areas', $area->state)->with('success', 'تم تعديل البيانات بنجاح.');
        }

        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        if ($area->delete()) {
            return response()->json('تم الحذف بنجاح.', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
