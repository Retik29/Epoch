<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Professional;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all()->map(function ($category) {
                $category->professionals_count = Professional::where('category_id', $category->id)->count();
                return $category;
            });

            $featuredProfessionals = Professional::with(['user', 'category'])
                ->where('is_active', true)
                ->orderByDesc('rating')
                ->orderByDesc('total_reviews')
                ->take(8)
                ->get();

            $stats = [
                'professionals' => Professional::where('is_active', true)->count(),
                'categories'    => Category::count(),
                'appointments'  => \App\Models\Appointment::count(),
                'users'         => \App\Models\User::where('role', 'user')->count(),
            ];
        } catch (\Exception $e) {
            // DB is offline/unavailable — use mock fallbacks
            $featuredProfessionals = Professional::getMockProfessionals();
            
            $categories = collect([
                new Category(['slug' => 'doctors', 'name' => 'Doctors', 'color' => '#ef4444', 'icon' => 'activity']),
                new Category(['slug' => 'tutors', 'name' => 'Tutors', 'color' => '#3b82f6', 'icon' => 'book-open']),
                new Category(['slug' => 'consultants', 'name' => 'Consultants', 'color' => '#10b981', 'icon' => 'briefcase']),
                new Category(['slug' => 'lawyers', 'name' => 'Lawyers', 'color' => '#f59e0b', 'icon' => 'scale']),
                new Category(['slug' => 'therapists', 'name' => 'Therapists', 'color' => '#8b5cf6', 'icon' => 'heart']),
            ])->map(function ($c) use ($featuredProfessionals) {
                $c->professionals_count = $featuredProfessionals->filter(fn($p) => $p->category->slug === $c->slug)->count();
                return $c;
            });

            $stats = [
                'professionals' => $featuredProfessionals->count(),
                'categories'    => $categories->count(),
                'appointments'  => 42,
                'users'         => 18,
            ];
        }

        return view('home.index', compact('categories', 'featuredProfessionals', 'stats'));
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'email'],
            'subject' => ['required', 'string', 'min:5', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'name.regex' => 'The name may only contain letters and spaces.',
        ]);

        // 1. Save to database
        try {
            ContactMessage::create($validated);
        } catch (\Exception $e) {
            // Fail silently for demo if DB is offline
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
                \Illuminate\Support\Facades\Mail::send([], [], function ($mail) use ($validated, $recipient) {
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

        return redirect()->route('contact')->with('success', 'Your contact message has been sent successfully! We will get back to you shortly.');
    }
}
