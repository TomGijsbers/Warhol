<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Http;

class DalleController extends Controller
{
    public function search(Request $request)
    {
        $api_key = env('OPENAI_SECRET');

        $res = Http::withHeaders([
            'Authorization' => 'Bearer ' . $api_key,
        ])->post('https://api.openai.com/v1/images/generations', [
            'prompt' => $request->get('query'),
        ]);

        return isset($res->json()["data"]) ? $res->json()["data"][0]['url'] : 'Not found';



    }
}

