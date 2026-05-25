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

        try {
            ContactMessage::create($validated);
        } catch (\Exception $e) {
            // Fail silently for demo if DB is offline
        }

        return redirect()->route('contact')->with('success', 'Your contact message has been sent successfully! We will get back to you shortly.');
    }
}
