<?php

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\User;
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

function countDeletedElements()
{
    $points = count(PointOfInterest::onlyTrashed()->get());
    $places = count(Place::onlyTrashed()->get());
    $videos = count(Video::onlyTrashed()->get());
    $photos = count(Photography::onlyTrashed()->get());

    $total = $points + $places + $videos + $photos;

    return $total;
}

function countUnVerifiedUsersHelper()
{
    $count = 0;
    foreach (User::role('Usuario sin verificar')->get() as $user) {
        $count++;
    }
    return $count;
}

function getDescripcionCorta($n_caracteres, $description)
{
    $caracteresDescription = strlen($description);

    if ($caracteresDescription > 50) {
        return substr($description, 0, $n_caracteres) . '...';
    }
    return $description;
}