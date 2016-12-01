<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Template as Model; 
use App\Entities\TemplateLog; 

/**
 * Used in Template model
 *
 * @author cmooy
 */
class TemplateObserver 
{
	public function created($model)
	{
		$log 				= new TemplateLog;
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
			$log 			= new TemplateLog;
			$attr 			= $model['attributes'];
			$attr['parent']	= $attr['_id'];
			unset($attr['_id']);

			$log->fill($attr);
			$log->save();
		}

		return true;
	}
}
