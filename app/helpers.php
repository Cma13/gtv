<?php

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\Video;

function countVerifyElementsHelper()
{
    $points = count(PointOfInterest::where('verified', false)->get());
    $places = count(Place::where('verified', false)->get());
    $videos = count(Video::where('verified', false)->get());
    $photos = count(Photography::where('verified', false)->get());

    $total = $points + $places + $videos + $photos;

    return $total;
}