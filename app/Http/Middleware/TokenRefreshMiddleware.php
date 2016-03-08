<?php
namespace App\Http\Middleware;

use Closure;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

use Symfony\Component\HttpFoundation\Cookie;

class TokenRefreshMiddleware 
{


	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

    	$response = $next($request);
        
    	$key = getenv('APP_KEY');
        $signer = new Sha256();
        $token = (new Builder())->setIssuer($request->server('REMOTE_ADDR')) // Configures the issuer (iss claim)
                        ->setAudience($request->server('HTTP_HOST')) // Configures the audience (aud claim)
                        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                        ->setNotBefore(time()) // Configures the time that the token can be used (nbf claim)
                        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                        ->set('uid', getenv('USER')) // Configures a new claim, called "uid"
                        ->sign($signer, $key) // creates a signature using "testing" as key
                        ->getToken(); // Retrieves the generated token
        
        $response->withCookie(new Cookie("TOKEN", $token->__toString()));
        
      	return $response;
    }

}