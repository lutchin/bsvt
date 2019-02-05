<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $fillable = ['title'];

    public function articles () {
        return $this->belongsToMany('App\ArticleReports');
    }

    public function countries () {
        return $this->belongsToMany('App\Models\Country');
    }

    public function personalities () {
        return $this->belongsToMany('App\Models\Personality');
    }

    public function vvttypes () {
        return $this->belongsToMany('App\Models\VvtType');
    }
}
