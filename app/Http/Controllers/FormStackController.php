<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

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
                'id'         => $form['id'],
                'name'       => $form['name'],
                'created_at' => $form['created'] ?? null,
                'updated_at' => $form['updated'] ?? null,
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
            

            /*if($formId=="5665395"){
                            
                echo "Form ID: ".$formId."<br />";
                echo "Form Name: ".$formName."<br />";
                echo "Form Date: ".$formDate."<br />";
                

                $submissionsResponse = Http::withToken(config('services.formstack.token'))
                    ->acceptJson()
                    ->get("https://www.formstack.com/api/v2/form/{$formId}/submission.json", 
                        [
                            'data' => 1
                        ]
                    );
                
                $submissions = collect(
                    $submissionsResponse->json()['submissions'] ?? []
                )->map(function ($submission) {

                    $data = $submission['data'] ?? [];

                    $candidate = collect($data)->mapWithKeys(
                        fn ($value, $key) => ['field_' . $key => $value]
                    );

                    echo "Submission Id: " . $submission['id'] . "<br /><br />";

                    // echo "Candidate Info<br />";
                    // foreach ($candidate as $field => $value) {
                    //     echo ucfirst(str_replace('_', ' ', $field)) . ": ";
                    //     echo is_array($value) ? implode(', ', $value) : $value;
                    //     echo "<br /><br />";
                    // }

                    echo "###################################################################<br />";
                    echo "###################################################################<br />";
                    echo "###################################################################<br />";
                    echo "###################################################################<br /><br /><br />";

                });
            }*/

            
        }
        
    }   

    public function fetchFormSubmissions($formId){

        $submissionsResponse = Http::withToken(config('services.formstack.token'))
            ->acceptJson()
            ->get("https://www.formstack.com/api/v2/form/{$formId}/submission.json", 
                [
                    'data' => 1
                ]
            );
        
        $submissions = collect(
            $submissionsResponse->json()['submissions'] ?? []
        )->map(function ($submission) {

            $data = $submission['data'] ?? [];

            $candidate = collect($data)->mapWithKeys(
                fn ($value, $key) => ['field_' . $key => $value]
            );

            echo "Submission Id: " . $submission['id'] . "<br /><br />";

            // echo "Candidate Info<br />";
            // foreach ($candidate as $field => $value) {
            //     echo ucfirst(str_replace('_', ' ', $field)) . ": ";
            //     echo is_array($value) ? implode(', ', $value) : $value;
            //     echo "<br /><br />";
            // }

            echo "###################################################################<br />";
            echo "###################################################################<br />";
            echo "###################################################################<br />";
            echo "###################################################################<br /><br /><br />";

        });

    }

    public function extractSubmission($id){

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
