<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Param\ParamFilterTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Param\StoreRequest;
use App\Http\Requests\Admin\Param\UpdateRequest;
use App\Http\Resources\Param\ParamResource;
use App\Models\Param;
use App\Services\ParamService;
use Inertia\Inertia;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $params = Param::all();
        $params = ParamResource::collection($params)->resolve();

        return Inertia::render('admin/param/Index', compact('params'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filterTypes = ParamFilterTypeEnum::collection();
        return Inertia::render('admin/param/Create', compact('filterTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $param = ParamService::store($data);

        return back()->with('success', "Parameter $param[title] created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Param $param)
    {
        $param = ParamResource::make($param)->resolve();

        return Inertia::render('admin/param/Show', compact('param'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Param $param)
    {
        $param = ParamResource::make($param)->resolve();
        $filterTypes = ParamFilterTypeEnum::collection();

        return Inertia::render('admin/param/Edit', compact('param', 'filterTypes'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Param $param)
    {
        $data = $request->validated();
        $param = ParamService::update($param, $data);

        return redirect()->back()->with('success', "Parameter $param[title] updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Param $param)
    {
        $param->delete();

        return redirect()->back()->with('success', "Category deleted successfully");

    }
}
