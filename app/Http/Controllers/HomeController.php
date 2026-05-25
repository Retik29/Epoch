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

        ContactMessage::create($validated);

        return redirect()->route('contact')->with('success', 'Your contact message has been sent successfully! We will get back to you shortly.');
    }
}
