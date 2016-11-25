<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Template as Model; 

/**
 * Used in Template model
 *
 * @author cmooy
 */
class TemplateObserver 
{
	public function saving($model)
	{
		return true;
	}
}
