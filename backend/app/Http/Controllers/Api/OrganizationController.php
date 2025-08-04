<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RadiusRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use App\Services\GeospatialService;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function nearby(RadiusRequest $request, GeospatialService $service)
    {
        $data = $request->validated();

        $organizations = $service->withinRadius(
                    $data['lat'],
                    $data['lng'],
                    $data['radius']
                )->get();

        return response()->json($organizations);
    }


    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    public function search(Request $request)
    {
        $request->validate(['query' => 'required|string|min:2']);

        return OrganizationResource::collection(Organization::where('name', 'ILIKE', "%{$request->query}%")
            ->with('phones', 'building', 'activities')
            ->get());
    }
}
