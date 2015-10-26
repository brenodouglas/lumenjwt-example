<?php

namespace Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{	

	public function indexAction() 
	{
		return ['error' => 0, 'data' => [ ['nome' => 'Breno Douglas'], ['nome' => 'Gustavo Lima'] ] ];		
	}
    
}
