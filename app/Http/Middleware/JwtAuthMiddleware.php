<?php
namespace App\Http\Middleware;

use Closure;

use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Parser;

class JwtAuthMiddleware
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
        $token = $request->header('access-token');
        
        $token = isset($token) ? $request->header('access-token') : $request->get('api_token');
        
        if(! $token)
            return response('Unauthorized.', 403);

        $key = getenv('APP_KEY');
        
        $signer = new Sha256();
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($request->server('REMOTE_ADDR'));
        $data->setAudience($request->server('HTTP_HOST'));
        
        try {
            $token = (new Parser())->parse((string) $token); 
            
            if(! $token->validate($data))
                return response('Unauthorized data', 401);

            if(! $token->verify($signer, $key))
                return response('Unauthorized sign', 401);

            putenv("USER=".$token->getClaim('uid'));
            
            return $next($request);
        } catch(\Exception $e) {
            return response('Unauthorized: '.$e->getMessage(), 403);
        } 
    }
}
