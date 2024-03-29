<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StatesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Str;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Country $country, StatesDataTable $dataTable)
    {
        return $dataTable
            ->render('admin.states.states', ['country' => $country]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        $state = new State;
        $state->name = $request->name;
        $slug = Str::slug($request->name);
        $state->slug = State::where('slug', $slug)->count() ? $slug.'-'.uniqid() : $slug;
        $state->country_id = $request->country_id;

        if ($state->save()) {
            return response()->json('تم الحفظ بنجاح!', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        return view('admin.states.edit-state')->with([
            'country' => $state->country,
            'state' => $state,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        $state->name = $request->name;
        $slug = Str::slug($request->name);
        $state->slug = State::where('slug', $slug)->where('id', '!=', $state->id)->count() ? $slug.'-'.uniqid() : $slug;

        if ($state->save()) {
            return redirect()->route('states', $state->country)->with('success', 'تم تعديل البيانات بنجاح.');
        }

        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        if ($state->delete()) {
            return response()->json('تم الحذف بنجاح.', 200);
        }

        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }

    public function areas(State $state)
    {
        $areas = [];
        foreach ($state->areas as $area) {
            $areas[$area->slug] = $area->name;
        }

        return json_encode($areas);
    }
}
