<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class JsonApi
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->headers->has('Content-Type')) {
            $contentTypeHeader = $request->header('Content-Type');
            if(preg_match('/application\/vnd\.api\+json; media-type=/',$contentTypeHeader)) {
                throw new UnsupportedMediaTypeHttpException();
            }
        }

        if($request->headers->has('Accept')) {
            $acceptHeader = $request->header('Accept');
            if(preg_match('/application\/vnd\.api\+json; media-type=/',$acceptHeader)) {
                throw new NotAcceptableHttpException();
            }
        }

        return $next($request);
    }
}
