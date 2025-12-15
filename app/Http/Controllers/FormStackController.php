<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class FormStackController extends Controller
{
    //

    public function getForms(){

        $response = Http::withToken(config('services.formstack.token'))
            ->acceptJson()
            ->get('https://www.formstack.com/api/v2/form.json');

        if ($response->failed()) {
            return response()->json([
                'error' => 'Failed to fetch forms',
                'details' => $response->json()
            ], $response->status());
        }


        $data = $response->json();

        // Normalize the result
        $forms = collect($data['forms'] ?? [])
            ->map(fn ($form) => [
                'id'         => $form['id'],
                'name'       => $form['name'],
                'created_at' => $form['created'] ?? null,
                'updated_at' => $form['updated'] ?? null,
            ])
            ->values();

            dd($forms);

       

    }   

}
