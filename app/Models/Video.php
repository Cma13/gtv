<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updater');
    }

    public function pointOfInterest()
    {
        return $this->belongsTo(PointOfInterest::class);
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
