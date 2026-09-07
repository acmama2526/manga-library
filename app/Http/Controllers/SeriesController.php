<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seriesList=Series::orderBy('title')->get();
        return view('series.index',compact('seriesList'));
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
        $validated=$request->validate([
            'title'=>'required|string|max:255',
            'author'=>'nullable|string|max:255',
            'genre'=>'nullable|string|max:255',
        ]);

        Series::create($validated);

        return redirect()->route('series.index')->with('success','作品を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $series=Series::findOrFail($id);
        return view('series.edit',compact('series'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $series=Series::findOrFail($id);

        $validated=$request->validate([
            'title'=>'required|string|max:255',
            'author'=>'nullable|string|max:255',
            'genre'=>'nullable|string|max:255',
        ]);
        $series->update($validated);

        return redirect()->route('series.index')->with('success','作品を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $series=Series::findOrFail($id);
        $series->delete();

        return redirect()->route('series.index')->with('success','作品を削除しました');
    }
}
