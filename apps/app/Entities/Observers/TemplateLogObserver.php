<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\TemplateLog as Model; 

/**
 * Used in TemplateLog model
 *
 * @author cmooy
 */
class TemplateLogObserver 
{
	public function created($model)
	{
		$prev 			= Model::parent($model->parent)->notid($model->_id)->orderby('created_at', 'desc')->first();

		if(!is_null($prev))
		{
			$prev->next 	= $model->_id;
			$prev->save();
		}

		return true;
	}
}
