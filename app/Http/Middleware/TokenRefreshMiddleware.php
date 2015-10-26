<?php
namespace App\Http\Middleware;

use Closure;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;

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

    	$token = $request->header('access-token');
    	$tokenParsed = (new Parser())->parse((string) $token); 

    	$key = getenv('APP_KEY');
        $signer = new Sha256();
        $token = (new Builder())->setIssuer($request->server('SERVER_ADDR')) // Configures the issuer (iss claim)
                        ->setAudience($request->server('REMOTE_HOST')) // Configures the audience (aud claim)
                        ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
                        ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
                        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
                        ->set('uid', $tokenParsed->getClaim('uid')) // Configures a new claim, called "uid"
                        ->sign($signer, $key) // creates a signature using "testing" as key
                        ->getToken(); // Retrieves the generated token

      	$response->withCookie($token->__toString());
	
      	return $response;
    }

}