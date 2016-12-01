<?php

namespace App\Entities;

use App\Entities\Observers\DocumentLogObserver;

/**
 * Used for DocumentLog Models
 * 
 * @author cmooy
 */
class DocumentLog extends BaseModel
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $collection			= 'service_document_logs';

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
											'type'							,
											'paragraph'						,
											'writer'						,
											'owner'							,
											'parent'						,
											'next'							,
										];
										
	/**
	 * Basic rule of database
	 *
	 * @var array
	 */
	protected $rules				=	[
											'title'							=> 'required|max:255',
											'type'							=> 'required|max:255',
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

		DocumentLog::observe(new DocumentLogObserver);
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
	 * scope to get condition where type
	 *
	 * @param string or array of type
	 **/
	public function scopeType($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('type', $variable);
		}

		return $query->where('type', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}

	/**
	 * scope to get condition where owner
	 *
	 * @param string or array of owner
	 **/
	public function scopeOwnerID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('owner._id', $variable);
		}

		return $query->where('owner._id', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}

	/**
	 * scope to get condition where writer
	 *
	 * @param string or array of writer
	 **/
	public function scopeWriterID($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('writer._id', $variable);
		}

		return $query->where('writer._id', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}

	/**
	 * scope to get condition where parent
	 *
	 * @param string or array of parent
	 **/
	public function scopeParent($query, $variable)
	{
		if(is_array($variable))
		{
			return 	$query->whereIn('parent', $variable);
		}

		return $query->where('parent', 'regexp', '/^'. preg_quote($variable) .'$/i');
	}

	/**
	 * scope to get condition where there is no next list
	 *
	 * @param string or array of there is no next list
	 **/
	public function scopeNoNext($query, $variable)
	{
		return $query->wherenull('next');
	}
}
