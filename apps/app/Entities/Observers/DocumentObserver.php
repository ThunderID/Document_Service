<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Document as Model; 
use App\Entities\DocumentLog; 

/**
 * Used in Document model
 *
 * @author cmooy
 */
class DocumentObserver 
{
	public function created($model)
	{
		$log 				= new DocumentLog;
		$attr 				= $model['attributes'];
		$attr['parent']		= $model->_id;

		$log->fill($attr);
		$log->save();

		return true;
	}

	public function updating($model)
	{
		if($model->isDirty('type'))
		{
			$log 			= new DocumentLog;
			$attr 			= $model['attributes'];
			$attr['parent']	= $attr['_id'];
			unset($attr['_id']);

			$log->fill($attr);
			$log->save();
		}

		return true;
	}
}
