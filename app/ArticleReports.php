<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleReports extends Model
{
	protected $fillable = [
		'title',
		'date_start',
		'date_end',
		'status',
		'description',
	];

	public function reports (){
		return $this->belongsTo('App\Report','report_id');
	}

    public function category () {
        return $this->belongsTo('App\Category');
    }
    public function subcategory () {
        return $this->belongsTo('App\Subcategory');
    }

	public function companies (  ) {
		return $this->belongsToMany('App\Models\Company');
	}
	public function countries (  ) {
		return $this->belongsToMany('App\Models\Country');
	}
	public function personalities (  ) {
		return $this->belongsToMany('App\Models\Personality');
	}
	public function vvttypes (  ) {
		return $this->belongsToMany('App\Models\VvtType');
	}
	public function users (  ) {
		return $this->belongsTo('App\User');
	}
	public function scopeActive($query)
	{
		return $query->where('published', 2);
	}
	public function scopeWithout_tags ( $query ) {
		return $query->doesnthave('countries')
		             ->doesnthave('companies')
		             ->doesnthave('personalities')
		             ->doesnthave('vvttypes');

	}

    public function images () {

	    return $this->hasMany('App\Image');

    }
}
