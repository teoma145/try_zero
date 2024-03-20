<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $activities = DB::table('activities')->get();

        $parentLavorataStatus = $this->getParentLavorataStatus($activities);


        return view('home', ['activities' => $activities, 'parentLavorataStatus' => $parentLavorataStatus]);
    }


    private function getParentLavorataStatus($activities)
    {
        $parentLavorataStatus = [];

    foreach ($activities as $activity) {
        if ($activity->padre !== null) {
            $parentActivities = $activities->where('padre', $activity->padre - 1);
            $allParentActivitiesLavorata = $parentActivities->every(function ($parentActivity) {
                return $parentActivity->lavorata;
            });

            $parentLavorataStatus[$activity->id] = $allParentActivitiesLavorata;
        } else {

            $nullParentActivitiesLavorata = $activities->where('padre', null)->every(function ($nullParentActivity) {
                return $nullParentActivity->lavorata;
            });

            $parentLavorataStatus[$activity->id] = $nullParentActivitiesLavorata;
        }
    }

    return $parentLavorataStatus;
    }


    public function lavoraAttivita($id)
    {

        DB::table('activities')->where('id', $id)->update(['lavorata' => true]);

    $activity = DB::table('activities')->where('id', $id)->first();

    if ($activity->padre !== null) {
        $allParentActivities = DB::table('activities')
            ->where('id', '<', $activity->padre)
            ->where('lavorata', false)
            ->exists();


        if (!$allParentActivities) {

            $nextParentId = $activity->padre + 1;
            DB::table('activities')->where('id', $nextParentId)->update(['lavorata' => true]);
        }
    }

    return redirect()->back();
    }
}
