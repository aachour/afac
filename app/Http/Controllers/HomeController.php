<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Contacts;
use App\Models\Subscribers;
use App\Models\BusinessPlan;
use App\Models\BusinessPlanFiles;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class HomeController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function blogs()
    {
        return view('frontend.blogs');
    }
    
    public function solutions()
    {
        return view('frontend.our-solutions');
    }

    public function community()
    {
        return view('frontend.community');
    }
    
    public function visionReality()
    {
        return view('frontend.vision-reality');
    }

    public function discover()
    {
        return view('frontend.discover');
    }

    public function visionaries()
    {
        return view('frontend.visionaries');
    }

    public function opportunities()
    {
        return view('frontend.opportunities');
    }

    public function business()
    {
        return view('frontend.business-plan');
    }

    public function businessSave(Request $request)
    {
        // Validate the form data
        $rules = [
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'industry' => 'required|string',
            'stage_of_business' => 'required|string',
            'funding' => 'required|string',
            'estimate' => 'required|string',
            'used_funding' => 'nullable|string',
            'files' => 'required|array',
            'files.*' => 'file|mimes:pdf,docx,doc|max:10500', // Fix applied here
        ];

        // If summary_status is NOT checked, require summary field
        if (!$request->has('summary_status')) {
            $rules['summary'] = 'required|string';
        }

        // If problem_status is NOT checked, require problem field
        if (!$request->has('problem_status')) {
            $rules['problem'] = 'required|string';
        }

        // If target_status is NOT checked, require target field
        if (!$request->has('target_status')) {
            $rules['target'] = 'required|string';
        }

        // If advantage_status is NOT checked, require advantage field
        if (!$request->has('advantage_status')) {
            $rules['advantage'] = 'required|string';
        }

        // If founder_status is NOT checked, require founder field
        if (!$request->has('founder_status')) {
            $rules['founder'] = 'required|string';
        }

        // If advisor_status is NOT checked, require advisor field
        if (!$request->has('advisor_status')) {
            $rules['advisor'] = 'required|string';
        }

        // If used_funding_status is NOT checked, require used_funding field
        if (!$request->has('used_funding_status')) {
            $rules['used_funding'] = 'required|string';
        }

        $messages = [
            'name.required' => 'Business Name is required.',
            'website.url' => 'Please enter a valid website URL.',
            'industry.required' => 'Industry field is required.',
            'stage_of_business.required' => 'Please select the stage of your business.',
            'summary.required' => 'Please provide a brief business summary or check the box if it is included in your documents.',
            'problem.required' => 'Please describe the problem your business solves or check the box if it is included in your documents.',
            'target.required' => 'Please describe your target customers or check the box if it is included in your documents.',
            'advantage.required' => 'Please explain your competitive advantage or check the box if it is included in your documents.',
            'funding.required' => 'Please select your funding status.',
            'estimate.required' => 'Please provide an estimated amount of funding you are seeking.',
            'used_funding.required' => 'Please specify what the funding will be used for or check the box if it is included in your documents.',
            'founder.required' => 'Please provide the founder(s) name(s) and background or check the box if it is included in your documents.',
            'advisor.required' => 'Please list any advisors or mentors or check the box if it is included in your documents.',
            'files.required' => 'Please upload at least one document.',
            //'files.*.mimes' => 'files must be in PDF, DOCX, or DOC format.',
            'files.*.max' => 'Each files must not exceed 10MB in size.',
        ];

        // Validate request data
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Save Business Plan
        $businessPlan = BusinessPlan::create([
            'name' => $request->name,
            'website' => $request->website,
            'industry' => $request->industry,
            'stage_of_business' => $request->stage_of_business,
            'summary_status' => $request->summary_status ?? '0',
            'summary' => $request->summary,
            'problem_status' => $request->problem_status ?? '0',
            'problem' => $request->problem,
            'target_status' => $request->target_status ?? '0',
            'target' => $request->target,
            'advantage_status' => $request->advantage_status ?? '0',
            'advantage' => $request->advantage,
            'funding' => $request->funding,
            'estimate' => $request->estimate,
            'used_funding_status' => $request->used_funding_status ?? '0',
            'used_funding' => $request->used_funding,
            'founder_status' => $request->founder_status ?? '0',
            'founder' => $request->founder,
            'advisor_status' => $request->advisor_status ?? '0', 
            'advisor' => $request->advisor,
        ]);

        $businessPlanId=$businessPlan->id;

        // Handle file uploads
        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ((array)$request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $fileName); // Store in 'public/uploads'
                $uploadedFiles[] = $fileName;

                BusinessPlanFiles::create([
                    'business_plan_id' => $businessPlanId,
                    'file' => $fileName,
                ]);
            }
        }

        //send message notification
        $this->sendEmail("11B New Business Plan", "Please log in and review your CMS at your earliest convenience.");

        return response()->json([
            'status' => 'success',
            'message' => 'Your request has been submitted successfully!'
        ]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactSave(Request $request)
    {
        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        // Save the data into the database
        Contacts::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ]);

        //send message notification
        $this->sendEmail("11B New Contact", "Please log in and review your CMS at your earliest convenience.");

        // Return a response (can be JSON for AJAX or a redirect)
        return response('Message sent successfully!', 200);
    }

    public function subscribeSave(Request $request)
    {

        // Validate the email
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        // Save email to database
        Subscribers::create([
            'email' => $request->email,
        ]);

        //send message notification
        $this->sendEmail("11B New Subscriber", "Please log in and review your CMS at your earliest convenience.");

        // Return a plain text success message
        return response('Subscription successful!', 200);
    }


    public function sendEmail($subject,$message){

        $mail = new PHPMailer(true);

        return 1;

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com'; // Hostinger SMTP Server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'your-email@11v.vc'; // Your email
            $mail->Password   = 'your-email-password'; // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Secure encryption
            $mail->Port       = 465; // SMTP Port

            // Email settings
            $mail->setFrom('info@11b.com', 'Your Name');
            $mail->addAddress('guy@11b.vc'); // Recipient email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return "1";
        } catch (Exception $e) {
            return "-1";
        }
    }


}
