<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\NewsLetter;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\IpUtils;

class FormController extends Controller
{

    public function send(Request $request)
    {
        // dd($request->all());
        $recaptcha_response = $request->input('g-recaptcha-response');
        if (is_null($recaptcha_response)) {
            return redirect()->back()->with('error', 'Please Complete the Recaptcha to proceed');
        }

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $body = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha_response,
            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ];

        $response = Http::asForm()->post($url, $body);

        $result = json_decode($response);

        if ($response->successful() && $result->success == true) {
            if ($request->nameapp) {
                $appointment = new Appointment();
                $appointment->name = $request->nameapp;
                $appointment->email = $request->emailapp;
                $appointment->phone_no = $request->numberapp;
                $appointment->treatment = $request->treatments;
                $appointment->date = $request->date;
                $appointment->save();
            } else {
                $contact = new Contact();
                $contact->name = $request->name;
                $contact->email = $request->email;
                $contact->phone_no = $request->number;
                $contact->subject = $request->subject;
                $contact->query = $request->request_data ? $request->request_data : null;
                $contact->save();
            }
            $data['item'] = $request->all();
            Mail::send('front.send', $data, function ($message) use ($data) {
                $message->to('alokikhospital99@gmail.com')
                    ->subject('Contact Enquiry');
            });
            // Session::flash('toastr', ['type' => 'success', 'message' => 'Email has been sent successfully.']);

            // return back();


            // Session::flash('toastr', ['type' => 'success', 'message' => 'Email has been sent successfully.']);

            return back()->with('success', 'Email has been send successfully.');
        } else {
            return redirect()->back()->with('status', 'Please Complete the Recaptcha Again to proceed');
        }
        // return view('front.contact');
    }


    public function newsLetter(Request $request)
    {
        $newsLetter = new NewsLetter();
        if ($request->email) {
            $newsLetter->email = $request->email;
            if ($newsLetter->save()) {
                $data['item'] = $request->all();
                Mail::send('front.send', $data, function ($message) use ($data) {
                    $message->to("alokikhospital99@gmail.com")
                        ->subject('News Letter');
                });
                return back()->with('success', 'Email has been send successfully.');
            }
        } else {
            return back()->with('error', 'Please enter an Email Id.');
        }
    }
}
