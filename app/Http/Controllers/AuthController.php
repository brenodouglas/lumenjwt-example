<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

use App\Domain\User\Service as UserService;


class AuthController extends BaseController
{

    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

	public function auth(Request $request) 
	{
		$credentials = $request->json()->all();
        
	    if (! $token = $this->service->authenticate($request)) 
	    	return response("Login or password invalid", 401);

        return response()->json(['error' => 0, 'token' => $token]);
	}

}