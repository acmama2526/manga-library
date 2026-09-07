<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use App\Models\Series;
use App\Models\Platform;
use Illuminate\Http\Request;

class VolumeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $keyword = $request->query('search');

    $volumes = Volume::where('user_id', auth()->id())->with(['series', 'platform']);

    if ($keyword) {
        $volumes->whereHas('series', function ($q) use ($keyword) {
            $q->where('title', 'like', '%' . $keyword . '%');
        });
    }

    $volumes = $volumes->orderBy('volume_number')->get()->groupBy('series_id');

    $seriesList = Series::orderBy('title')->get();
    $platforms = Platform::orderBy('name')->get();
    $selectedSeriesId = $request->query('series_id');

    return view('volumes.index', compact('volumes', 'seriesList', 'platforms', 'selectedSeriesId'));
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
        $validated = $request->validate([
            'series_id' => 'required|exists:series,id',
            'platform_id' => 'required|exists:platforms,id',
            'volume_number' => 'required|integer|min:1',
            'purchase_date' => 'nullable|date',
            'is_read' => 'nullable|boolean',
            'read_url'=>'nullable|url|max:2048',
        ]);
        
        $validated['user_id']=auth()->id();
        $validated['is_read']=$request->has('is_read');

        Volume::create($validated);

        return redirect()->route('volumes.index')->with('success','巻データを登録しました');
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
        $volume=Volume::where('user_id',auth()->id())->findOrFail($id);
        $seriesList=Series::orderBy('title')->get();
        $platforms=Platform::orderBy('name')->get();

        return view('volumes.edit',compact('volume','seriesList','platforms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $volume=Volume::where('user_id',auth()->id())->findOrFail($id);

        $validated=$request->validate([
        'series_id' => 'required|exists:series,id',
        'platform_id' => 'required|exists:platforms,id',
        'volume_number' => 'required|integer|min:1',
        'purchase_date' => 'nullable|date',
        'is_read' => 'nullable|boolean', 
        'read_url'=>'nullable|url|max:2048',                 
        ]);

        $validated['is_read']=$request->has('is_read');

        $volume->update($validated);

        return redirect()->route('volumes.index')->with('success','巻データを更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $volume=Volume::where('user_id',auth()->id())->findOrFail($id);
        $volume->delete();

        return redirect()->route('volumes.index')->with('success','巻データを削除しました');
    }
}
