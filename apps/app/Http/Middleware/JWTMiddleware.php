<?php

namespace App\Http\Middleware;

use Closure;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class JWTMiddleware
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
		return $next($request);
		$token  = $request->header('Authorization');

		if(empty($token))
		{
			throw new \Exception('no JWT');
		}

		$tokens = explode(' ', $token);

		$token 	= $tokens[count($tokens) - 1];

		$token	= (new Parser())->parse((string) $token); // Parses from a string

		$data	= new ValidationData(); // It will use the current time to validate (iat, nbf and exp)

		$data->setIssuer(env('JWT_ISSUER','http://example.com'));
		$data->setAudience(env('JWT_AUDIENCE','http://example.org'));
		$data->setId(env('JWT_ID','4f1g23a12aa'));

		if($token->validate($data))
		{
			return $next($request);
		}

		throw new \Exception('invalid token');

		return $next($request);
	}
}
