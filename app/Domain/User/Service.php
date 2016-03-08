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
        
        $user = Auth::user();
        
        $key = getenv('APP_KEY');
        $signer = new Sha256();
        $token = (new Builder())->setIssuer($request->server('REMOTE_ADDR'))
                        ->setAudience($request->server('HTTP_HOST'))
                        ->setIssuedAt(time())
                        ->setNotBefore(time()) 
                        ->setExpiration(time() + 3600) 
                        ->set('uid', $user->id) 
                        ->sign($signer, $key) 
                        ->getToken();

        return $token->__toString();
    }

}