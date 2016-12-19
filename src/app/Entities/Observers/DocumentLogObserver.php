<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\DocumentLog as Model; 

/**
 * Used in DocumentLog model
 *
 * @author cmooy
 */
class DocumentLogObserver 
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
