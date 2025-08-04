<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function byActivity(Activity $activity)
    {
        $organizations = $activity->organizations()
            ->with('phones', 'building')
            ->get();
        return OrganizationResource::collection($organizations);
    }
    public function withTree(Activity $activity)
    {
        $activityIds = Activity::query()->where('id', $activity->id)
            ->orWhere('parent_id', $activity->id)
            ->orWhereIn('parent_id', function($query) use ($activity) {
                $query->select('id')
                    ->from('activities')
                    ->where('parent_id', $activity->id);
            })->pluck('id');

        $organization = Organization::query()->whereHas('activities', function($query) use ($activityIds) {
            $query->whereIn('activities.id', $activityIds);
        })->with('phones', 'building')->get();

        return OrganizationResource::collection($organization);
    }

    public function search(Request $request)
    {
        $activity = Activity::query()->where('name', $request->name)->first();
        if (empty($activity)) {
            abort(404, 'Activity not found');
        }

        return $this->withTree($activity);
    }
}
