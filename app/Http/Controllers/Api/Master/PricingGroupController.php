<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\PricingGroup;

class PricingGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pricingGroup = PricingGroup::eloquentFilter($request);

        $pricingGroup = pagination($pricingGroup, $request->get('limit'));

        return new ApiCollection($pricingGroup);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pricingGroup = new PricingGroup;
        $pricingGroup->fill($request->all());

        return new ApiResource($pricingGroup);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $pricingGroup = PricingGroup::eloquentFilter($request)->findOrFail($id);

        return new ApiResource($pricingGroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pricingGroup = PricingGroup::findOrFail($id);
        $pricingGroup->fill($request->all());
        $pricingGroup->save();

        return new ApiResource($pricingGroup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pricingGroup = PricingGroup::findOrFail($id);
        $pricingGroup->delete();

        return response()->json([], 204);
    }
}
