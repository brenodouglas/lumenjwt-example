<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

use App\Domain\User\Model as User;

class PessoaController extends BaseController
{	

	
	public function get(Request $request) 
	{
		$user = User::with(['email'])->get();

		$wheres = json_decode($request->query("where", '[]'));
		$fields = explode(',', $request->query('fields', 'id'));
		$offset = $request->query('offset', 0);
		$limit  = $request->query('limit', 30);
		$orderBy = json_decode($request->query('orderBy', '[]'));
		$groupBy = json_decode($request->query('groupBy', '[]'));

		return response()->json(['wheres' => $wheres]);
	}

	public function users(SymfonyRequest $request)
	{
		return response()->json(User::all());
	}
    
}
