<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use PDO;

class FormStackController extends Controller
{
    //

    public function fetchForms(){

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
                'id'                    => $form['id'],
                'name'                  => $form['name'],
                'language'              => $form['language'],
                'submissions'           => $form['submissions'],
                'is_workflow_form'      => $form['is_workflow_form'],
                'is_workflow_published' => $form['is_workflow_published'],
                'created_at'  => $form['created'] ?? null,
                'updated_at'  => $form['updated'] ?? null,
            ])
            ->values();

        foreach($forms as $form){

            //get submissions
            $formId=$form["id"];
            $formName=$form["name"];
            $formDate=$form["created_at"];

            echo "Form ID: ".$formId."<br />";
            echo "Form Name: ".$formName."<br />";
            echo "Form Date: ".$formDate."<br /><br /><br />";
            
        }
        
    }   

    public function fetchFormSubmissions($formId){

        $page = 1;
        $allSubmissions = [];

        do {
            $response = Http::withToken(config('services.formstack.token'))
                ->acceptJson()
                ->get("https://www.formstack.com/api/v2/form/{$formId}/submission.json", [
                    'data' => 1,
                    'page' => $page,
                ]);

            if (! $response->successful()) {
                dd($response->status(), $response->body());
            }

            $json = $response->json();

            // adjust this key if needed after one dd($json)
            $submissions = $json['submissions'] ?? [];

            $allSubmissions = array_merge($allSubmissions, $submissions);

            $page++;
        } while (! empty($submissions));

        foreach($allSubmissions as $submission){
            $submissionId=$submission["id"];
            echo $submissionId."<br />";
            $data=$submission["data"];

            $secondItem = array_values($data)[1];
            $email = $secondItem['value'] ?? null;

            echo $email."<br />";
        }


    }

    public function fetchSubmission($id){

        /*$submissionId = $id;

        $submission = Http::withToken(config('services.formstack.token'))
            ->get("https://www.formstack.com/api/v2/submission/{$submissionId}.json")
            ->json();

        $fieldData=[];
        foreach($submission['data'] as $data){
            $obj=[
                'label'=>$data["field"],
                'value'=>$data["value"],
            ];
            $fieldData[]=$obj;
        }

        return view('submission', [
            'submissionId' => $submissionId,
            'displayFields' => $fieldData
        ]);*/

        $submissionId = $id;

        $submission = Http::withToken(config('services.formstack.token'))
            ->get("https://www.formstack.com/api/v2/submission/{$submissionId}.json")
            ->json();

        $formId = $submission['form_id'] ?? null;

        $fieldLabels = [];

        if ($formId) {
            $form = Http::withToken(config('services.formstack.token'))
                ->get("https://www.formstack.com/api/v2/form/{$formId}.json")
                ->json();

            foreach (($form['fields'] ?? []) as $field) {
                $fieldLabels[(string)$field['id']] = $field['label']
                    ?? $field['name']
                    ?? $field['title']
                    ?? 'Unknown Field';
            }
        }

        $fieldData = [];

        foreach (($submission['data'] ?? []) as $item) {
            $fieldId = (string)($item['field'] ?? '');

            $fieldData[] = [
                'label' => $fieldLabels[$fieldId] ?? "Field #{$fieldId}",
                'value' => $item['value'] ?? null,
            ];
        }

        return view('submission', [
            'submissionId' => $submissionId,
            'displayFields' => $fieldData
        ]);
    }

}
