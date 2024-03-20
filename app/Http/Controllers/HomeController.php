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
                $parentActivities = $activities->where('padre', $activity->padre);
                $allParentActivitiesLavorata = $parentActivities->every(function ($parentActivity) {
                    return $parentActivity->lavorata;
                });

                $parentLavorataStatus[$activity->id] = $allParentActivitiesLavorata;
            } else {

                $parentLavorataStatus[$activity->id] = true;
            }
        }

        return $parentLavorataStatus;
    }

    public function lavoraAttivita($id)
    {
        DB::table('activities')->where('id', $id)->update(['lavorata' => true]);
        $activity = DB::table('activities')->where('id', $id)->first();

        if ($activity->padre !== null) {
            $allParentActivitiesLavorata = DB::table('activities')
                ->where('padre', $activity->padre)
                ->where('lavorata', false)
                ->doesntExist();

            if ($allParentActivitiesLavorata) {

                $nextParentId = $activity->padre + 1;
                DB::table('activities')->where('id', $nextParentId)->update(['lavorata' => true]);
            }
        }

        return redirect()->back();
    }
}
