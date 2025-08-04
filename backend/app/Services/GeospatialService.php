<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;

class GeospatialService
{
    /**
     * Фильтр организаций в радиусе от точки
     *
     * @param float $latitude
     * @param float $longitude
     * @param float $radius (в километрах)
     * @return Builder
     */
    public function withinRadius(
        float $latitude,
        float $longitude,
        float $radius
    ): Builder {
        return Organization::query()
            ->with('phones', 'building')
            ->whereHas('building', function ($buildingQuery) use ($latitude, $longitude, $radius) {

            $buildingQuery->whereRaw("ST_DistanceSphere(
                ST_MakePoint(longitude, latitude),
                ST_MakePoint(?, ?)
            ) <= ?", [$longitude, $latitude, $radius * 1000]);
        });
    }

    /**
     * Фильтр организаций в прямоугольной области
     *
     * @param float $minLat
     * @param float $minLng
     * @param float $maxLat
     * @param float $maxLng
     * @return Builder
     */
    public function withinBoundingBox(
        float $minLat,
        float $minLng,
        float $maxLat,
        float $maxLng
    ): Builder {
        return Organization::query()
            ->with('phones', 'building')
            ->whereHas('building', function ($buildingQuery) use ($minLat, $minLng, $maxLat, $maxLng) {
            $buildingQuery->whereBetween('latitude', [$minLat, $maxLat])
                ->whereBetween('longitude', [$minLng, $maxLng]);
        });
    }
}
