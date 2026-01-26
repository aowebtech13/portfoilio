<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only('name', 'email', 'subject', 'message');

        try {
            Mail::to(config('mail.from.address'))->send(new ContactMail($data));

            return response()->json([
                'status' => 'success',
                'message' => 'Your message has been sent successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send email. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
