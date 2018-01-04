<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Podcast;
use Illuminate\Http\Request;

class PodcastsController extends Controller
{
    public function index()
    {
        return response()->jsonApi(Podcast::all());
    }

    public function create(Request $request)
    {
        $podcast = Podcast::create($request->all());

        return response()->jsonApi($podcast, 201);
    }

    public function read(Podcast $podcast)
    {
        return response()->jsonApi($podcast);
    }

    public function update(Request $request, Podcast $podcast)
    {
        $podcast->update($request->all());

        return response()->jsonApi($podcast);
    }

    public function delete(Request $request, Podcast $podcast)
    {
        $podcast->delete();

        return response()->jsonApi("success", 204);
    }
}
