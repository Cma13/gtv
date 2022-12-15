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

    public function getDescripcionCorta($n_caracteres)
    {
        $caracteresDescription = strlen($this->description);

        if ($caracteresDescription > 50) {
            return substr($this->description, 0, $n_caracteres) . '...';
        }
        return $this->description;
    }
}
