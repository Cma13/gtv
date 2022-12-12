<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThematicArea extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pointsOfInterest(){
        return $this->belongsToMany(PointOfInterest::class)->withPivot('thematic_area_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['date', 'active']);
    }
}
