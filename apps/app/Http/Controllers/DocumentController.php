<?php

namespace App\Http\Controllers;

use App\Libraries\JSend;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Entities\Document;
use App\Entities\DocumentLog;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

/**
 * Document resource representation.
 *
 * @Resource("Documents", uri="/documents")
 */
class DocumentController extends Controller
{
	public function __construct(Request $request)
	{
		$this->request 				= $request;
	}

	/**
	 * Show all Documents
	 *
	 * @Get("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"search":{"id":"string","title":"string","writer":"string"},"sort":{"newest":"asc|desc","title":"desc|asc","writer":"desc|asc"}, "take":"integer", "skip":"integer"}),
	 *      @Response(200, body={"status": "success", "data": {"data":{"id":{"value":"123456789","type":"string","max":"255"},"title":{"value":"Template Akta Jual Beli Tanah","type":"string","max":"255"},"type":{"value":"akta|ktp","type":"string","max":"255"},"paragraph":{"value":{"Paragraph 1", "Paragraph 2"},"type":"array"},"writer":{"value":{"name":"Alana"},"type":"array"}},"count":"integer"} })
	 * })
	 */
	public function index()
	{
		$result						= new Document;

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

		$result 					= $this->getStructure($result->get()->toArray());
		
		return response()->json( JSend::success([array_merge($result, ['count' => $count])])->asArray())
				->setCallback($this->request->input('callback'));
	}

	/**
	 * Store Document
	 *
	 * @Post("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"id":null,"title":"string","paragraph":"array","writer":"array"}),
	 *      @Response(200, body={"status": "success", "data": {"id":{"value":"123456789","type":"string","max":"255"},"title":{"value":"Template Akta Jual Beli Tanah","type":"string","max":"255"},"type":{"value":"akta|ktp","type":"string","max":"255"},"paragraph":{"value":{"Paragraph 1", "Paragraph 2"},"type":"array"},"writer":{"value":{"name":"Alana"},"type":"array"}}}),
	 *      @Response(200, body={"status": {"error": {"writer name required."}}})
	 * })
	 */
	public function post()
	{
		$id 			= Input::get('id');

		if(!is_null($id) && !empty($id))
		{
			$result		= Document::id($id)->first();
		}
		else
		{
			$result 	= new Document;
		}
		
		$result->fill(Input::only('title', 'type', 'paragraph', 'writer'));

		if($result->save())
		{
			return response()->json( JSend::success($this->getStructure([$result->toArray()])['data'][0])->asArray())
					->setCallback($this->request->input('callback'));
		}
		
		return response()->json( JSend::error($result->getError())->asArray());
	}

	/**
	 * Delete Document
	 *
	 * @Delete("/")
	 * @Versions({"v1"})
	 * @Transaction({
	 *      @Request({"id":null}),
	 *      @Response(200, body={"status": "success", "data": {"id":{"value":"123456789","type":"string","max":"255"},"title":{"value":"Template Akta Jual Beli Tanah","type":"string","max":"255"},"type":{"value":"akta|ktp","type":"string","max":"255"},"paragraph":{"value":{"Paragraph 1", "Paragraph 2"},"type":"array"},"writer":{"value":{"name":"Alana"},"type":"array"}}}),
	 *      @Response(200, body={"status": {"error": {"writer name required."}}})
	 * })
	 */
	public function delete()
	{
		$document		= Document::id(Input::get('id'))->first();

		$result 		= $document;

		if($document && $document->delete())
		{
			return response()->json( JSend::success($this->getStructure([$result->toArray()])['data'][0])->asArray())
					->setCallback($this->request->input('callback'));
		}
		elseif(!$document)
		{
			return response()->json( JSend::error(['ID tidak valid'])->asArray());
		}

		return response()->json( JSend::error($document->getError())->asArray());
	}

	/**
	 * Fractal Modifying Returned Value
	 *
	 * getStructure method used to transforming response format and included UI inside (@UInside)
	 */
	public function getStructure($draft)
	{
		$fractal 					= new Manager();
		$resource 					= new Collection($draft, function(array $document) {
										return [
												'id' 	=> [
																'value' => $document['_id'],
																'type'	=> 'string',
																'max'	=> '255',
															],
												'title'	=> [
																'value' => $document['title'],
																'type'	=> 'string',
																'max'	=> '255',
															],
												'paragraph'	=> [
																'value' => $document['paragraph'],
																'type'	=> 'array',
																'max'	=> '255',
															],
												'writer'	=> [
																'value' => $document['writer'],
																'type'	=> 'array',
																'max'	=> '255',
															],
												'created_at'	=> [
																'value' => $document['created_at'],
																'type'	=> 'datetime',
																'zone'	=> env('APP_TIMEZONE', ''),
																'format'=> 'Y-m-d H:i:s',
															],
												'updated_at' 	=> [
																'value' => $document['updated_at'],
																'type'	=> 'datetime',
																'zone'	=> env('APP_TIMEZONE', ''),
																'format'=> 'Y-m-d H:i:s',
															],
												'deleted_at' 	=> [
																'value' => null,
																'type'	=> 'datetime',
																'zone'	=> env('APP_TIMEZONE', ''),
																'format'=> 'Y-m-d H:i:s',
															],
											];
										});

		// Turn that into a structured array (handy for XML views or auto-YAML converting)
		$array 						= $fractal->createData($resource)->toArray();

		return $array;
	}
}