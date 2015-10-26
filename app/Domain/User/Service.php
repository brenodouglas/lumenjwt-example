<?php
namespace App\Domain\User;

use Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Illuminate\Http\Request;

class Service 
{

	public function authenticate(Request $request) 
	{
		$credentials = $request->json()->all();

	  	if (! $user = Auth::attempt($credentials, $request->has('remember'))) 
            return false;

        $key = getenv('APP_KEY');
        $signer = new Sha256();
        $token = (new Builder())->setIssuer($request->server('SERVER_ADDR'))
                        ->setAudience($request->server('REMOTE_HOST'))
                        ->setId('4f1g23a12aa', true) 
                        ->setIssuedAt(time())
                        ->setNotBefore(time()) 
                        ->setExpiration(time() + 3600) 
                        ->set('uid', $user) 
                        ->sign($signer, $key) 
                        ->getToken();

        return $token->__toString();
	}

}