<?php

namespace App\Entities;

use App\Entities\Observers\TemplateObserver;

/**
 * Used for Template Models
 * 
 * @author cmooy
 */
class Template extends BaseModel
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $collection			= 'service_templates';

	/**
	 * Date will be returned as carbon
	 *
	 * @var array
	 */
	protected $dates				=	['created_at', 'updated_at', 'deleted_at'];

	/**
	 * The appends attributes from mutator and accessor
	 *
	 * @var array
	 */
	protected $appends				=	[];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden 				= [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable				=	[
											'title'							,
											'paragraph.*.content'			,
											'writer'						,
										];
										
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'title'							=> 'required|max:255',
											'paragraph.*.content'			=> 'required',
											'writer'						=> 'required',
										];


	/* ---------------------------------------------------------------------------- RELATIONSHIP ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- QUERY BUILDER ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- MUTATOR ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- ACCESSOR ----------------------------------------------------------------------------*/
	
	/* ---------------------------------------------------------------------------- FUNCTIONS ----------------------------------------------------------------------------*/
		
	/**
	 * boot
	 * observing model
	 *
	 */
	public static function boot() 
	{
        parent::boot();

		Template::observe(new TemplateObserver);
    }

	/* ---------------------------------------------------------------------------- SCOPES ----------------------------------------------------------------------------*/

	/**
	 * scope to get condition where title
	 *
	 * @param string or array of title
	 **/
	public function scopeTitle($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('title', $variable);
		}

		return $query->where('title', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}

	/**
	 * scope to get condition where writer
	 *
	 * @param string or array of writer
	 **/
	public function scopeWriter($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('writer', $variable);
		}

		return $query->where('writer', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}
}
