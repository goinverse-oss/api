<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use CloudCreativity\JsonApi\Document\Error;
use CloudCreativity\LaravelJsonApi\Http\Controllers\CreatesResponses;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use CreatesResponses;

    protected $api = 'v1';

    public function registerUser(Request $request)
    {
        try {
            $document = json_decode($request->getContent());
            $data = property_exists($document, 'data') && property_exists($document->data, 'attributes') ? (array)$document->data->attributes : [];
        } catch (\Exception $e) {
            $data = [];
        }

        $v = validator($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($v->fails()) {
            $error = new Error(null, null, 400, null, 'Validation Error', $v->errors()->first());
            return $this->reply()->error($error);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $client = \Laravel\Passport\Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);

        // Fire off the internal request.
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }
}