<?php

namespace App\Http\Controllers;

use App\Libraries\JSend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Entities\Template;

use Lcobucci\JWT\Parser;

/**
 * Template resource representation.
 *
 * @Resource("Templates", uri="/templates")
 */
class TemplateController extends Controller
{
	public function __construct(Request $request)
	{
		$this->request 				= $request;
	}

	/**
	 * Show all Templates
	 *
	 * @Get("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"search":{"id":"string","title":"string","writer":"string"},"sort":{"newest":"asc|desc","title":"desc|asc","writer":"desc|asc"}, "take":"integer", "skip":"integer"}),
	 *      @Response(200, body={"status": "success", "data": {"data":{"id":{"value":"123456789","type":"string","max":"255"},"title":{"value":"Template Akta Jual Beli Tanah","type":"string","max":"255"},"paragraph":{"value":{"Paragraph 1", "Paragraph 2"},"type":"array"},"writer":{"value":{"name":"Alana"},"type":"array"}},"count":"integer"} })
	 * })
	 */
	public function index()
	{
		$result						= new Template;

		if(Input::has('search'))
		{
			$search					= Input::get('search');

			foreach ($search as $key => $value) 
			{
				switch (strtolower($key)) 
				{
					case 'id':
						$result		= $result->id($value);
						break;
					case 'title':
						$result		= $result->title($value);
						break;
					case 'writer':
						$result		= $result->writer($value);
						break;
					default:
						# code...
						break;
				}
			}
		}

		if(Input::has('sort'))
		{
			$sort					= Input::get('sort');

			foreach ($sort as $key => $value) 
			{
				if(!in_array($value, ['asc', 'desc']))
				{
					return response()->json( JSend::error([$key.' harus bernilai asc atau desc.'])->asArray());
				}
				switch (strtolower($key)) 
				{
					case 'newest':
						$result		= $result->orderby('created_at', $value);
						break;
					case 'title':
						$result		= $result->orderby('title', $value);
						break;
					case 'writer':
						$result		= $result->orderby('writer', $value);
						break;
					default:
						# code...
						break;
				}
			}
		}

		$count						= count($result->get());

		if(Input::has('skip'))
		{
			$skip					= Input::get('skip');
			$result					= $result->skip($skip);
		}

		if(Input::has('take'))
		{
			$take					= Input::get('take');
			$result					= $result->take($take);
		}

		$result 					= $result->get()->toArray();
		
		return response()->json( JSend::success(['data' => $result, 'count' => $count])->asArray())
				->setCallback($this->request->input('callback'));
	}

	/**
	 * Store Template
	 *
	 * @Post("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"id":null,"title":"string","paragraph":"array","writer":"array"}),
	 *      @Response(200, body={"status": "success", "data": {"id":{"value":"123456789","type":"string","max":"255"},"title":{"value":"Template Akta Jual Beli Tanah","type":"string","max":"255"},"paragraph":{"value":{"Paragraph 1", "Paragraph 2"},"type":"array"},"writer":{"value":{"name":"Alana"},"type":"array"}}}),
	 *      @Response(200, body={"status": {"error": {"writer name required."}}})
	 * })
	 */
	public function post()
	{
		$id 			= Input::get('id');

		if(!is_null($id) && !empty($id))
		{
			$result		= Template::id($id)->first();
		}
		else
		{
			$result 	= new Template;
		}
		
		$result->fill(Input::only('title', 'paragraph', 'writer'));

		if($result->save())
		{
			return response()->json( JSend::success($result->toArray())->asArray())
						->setCallback($this->request->input('callback'));
		}
		
		return response()->json( JSend::error($result->getError())->asArray());
	}

	/**
	 * Delete Template
	 *
	 * @Delete("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"id":null}),
	 *      @Response(200, body={"status": "success", "data": {"id":{"value":"123456789","type":"string","max":"255"},"title":{"value":"Template Akta Jual Beli Tanah","type":"string","max":"255"},"paragraph":{"value":{"Paragraph 1", "Paragraph 2"},"type":"array"},"writer":{"value":{"name":"Alana"},"type":"array"}}}),
	 *      @Response(200, body={"status": {"error": {"writer name required."}}})
	 * })
	 */
	public function delete()
	{
		$template		= Template::id(Input::get('id'))->first();

		$result 		= $template;

		if($template && $template->delete())
		{
			return response()->json( JSend::success($result->toArray())->asArray())
					->setCallback($this->request->input('callback'));
		}
		elseif(!$template)
		{
			return response()->json( JSend::error(['ID tidak valid'])->asArray());
		}

		return response()->json( JSend::error($template->getError())->asArray());
	}
}