<?php 

namespace App\Entities\Observers;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

use App\Entities\Document as Model; 

/**
 * Used in Document model
 *
 * @author cmooy
 */
class DocumentObserver 
{
	public function saving($model)
	{
		return true;
	}
}
