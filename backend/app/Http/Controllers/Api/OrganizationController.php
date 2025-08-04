<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function byBuilding(Building $building)
    {
        return $building->organizations()
            ->with('phones', 'activities')
            ->get();
    }

    // Список организаций по виду деятельности
    public function byActivity(Activity $activity)
    {
        return $activity->organizations()
            ->with('phones', 'building')
            ->get();
    }

    // Организации в радиусе
    public function nearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'required|numeric|min:0'
        ]);

        $lat = $request->lat;
        $lng = $request->lng;
        $radius = $request->radius;

        return Organization::whereHas('building', function($query) use ($lat, $lng, $radius) {
            $query->whereRaw("ST_DistanceSphere(
                ST_MakePoint(longitude, latitude),
                ST_MakePoint(?, ?)
            ) <= ?", [$lng, $lat, $radius * 1000]);
        })->with('phones', 'building')->get();
    }

    // Информация об организации
    public function show(Organization $organization)
    {
        return $organization->load('phones', 'building', 'activities');
    }

    // Поиск по виду деятельности (с поддеревом)
    public function byActivityTree(Activity $activity)
    {
        $activityIds = Activity::where('id', $activity->id)
            ->orWhere('parent_id', $activity->id)
            ->orWhereIn('parent_id', function($query) use ($activity) {
                $query->select('id')
                    ->from('activities')
                    ->where('parent_id', $activity->id);
            })->pluck('id');

        return Organization::whereHas('activities', function($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->with('phones', 'building')->get();
    }

    // Поиск по названию организации
    public function search(Request $request)
    {
        $request->validate(['query' => 'required|string|min:2']);

        return Organization::where('name', 'ILIKE', "%{$request->query}%")
            ->with('phones', 'building', 'activities')
            ->get();
    }

    public function rectangele()
    {
        return Organization::whereHas('building', function($query) use ($minLat, $maxLat, $minLng, $maxLng) {
            $query->whereRaw("
        latitude BETWEEN ? AND ? AND longitude BETWEEN ? AND ?
    ", [$minLat, $maxLat, $minLng, $maxLng]);
        })->with('phones', 'building')->get();
    }
}
