<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        // 1. Save to database
        try {
            \App\Models\ContactMessage::create($validated);
        } catch (\Exception $e) {
            // Fail silently
        }

        // 2. Send email
        $accessKey = env('WEB3FORMS_ACCESS_KEY');
        if ($accessKey) {
            try {
                \Illuminate\Support\Facades\Http::post('https://api.web3forms.com/submit', [
                    'access_key' => $accessKey,
                    'name'       => $validated['name'],
                    'email'      => $validated['email'],
                    'subject'    => '[Epoch Contact] ' . $validated['subject'],
                    'message'    => $validated['message'],
                    'from_name'  => 'Epoch Platform',
                ]);
            } catch (\Exception $e) {
                // Fail silently
            }
        } else {
            try {
                $recipient = env('CONTACT_EMAIL', 'ritiknyadavofficial614@gmail.com');
                Mail::send([], [], function ($mail) use ($validated, $recipient) {
                    $mail->to($recipient)
                        ->replyTo($validated['email'], $validated['name'])
                        ->subject('[Epoch Contact] ' . $validated['subject'])
                        ->html(
                            '<div style="font-family:sans-serif;max-width:600px;margin:auto;padding:24px;background:#f9fafb;border-radius:12px;">
                                <h2 style="color:#4f46e5;margin-bottom:4px;">New Contact Message</h2>
                                <p style="color:#6b7280;font-size:13px;margin-top:0;">via Epoch Appointment Platform</p>
                                <hr style="border:none;border-top:1px solid #e5e7eb;margin:16px 0;">
                                <p><strong>Name:</strong> ' . e($validated['name']) . '</p>
                                <p><strong>Email:</strong> <a href="mailto:' . e($validated['email']) . '">' . e($validated['email']) . '</a></p>
                                <p><strong>Subject:</strong> ' . e($validated['subject']) . '</p>
                                <hr style="border:none;border-top:1px solid #e5e7eb;margin:16px 0;">
                                <p style="white-space:pre-wrap;">' . e($validated['message']) . '</p>
                            </div>'
                        );
                });
            } catch (\Exception $e) {
                // Fail silently
            }
        }

        return back()
            ->with('contact_success', true)
            ->with('contact_name', $validated['name']);
    }
}
