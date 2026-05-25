<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Professional;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfessionalController extends Controller
{
    public function index(Request $request)
    {
        $query = Professional::with(['user', 'category'])
            ->where('is_active', true);

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Name search
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        // Sorting
        $sort = $request->get('sort', 'rating');
        match($sort) {
            'rating'     => $query->orderByDesc('rating'),
            'experience' => $query->orderByDesc('experience_years'),
            'fee_low'    => $query->orderBy('consultation_fee'),
            'fee_high'   => $query->orderByDesc('consultation_fee'),
            default      => $query->orderByDesc('rating'),
        };

        // Store filters in session
        session(['last_filters' => $request->only(['category', 'location', 'search', 'sort'])]);

        $professionals = $query->paginate(12)->withQueryString();

        $categories = Category::all()->map(function ($category) {
            $category->professionals_count = Professional::where('category_id', $category->id)->count();
            return $category;
        });

        return view('professionals.index', compact('professionals', 'categories'));
    }

    public function show(Professional $professional)
    {
        $professional->load(['user', 'category', 'availabilities', 'reviews.user']);

        // Get available slots for next 7 days
        $availableDates = [];
        for ($i = 1; $i <= 14; $i++) {
            $date = now()->addDays($i)->format('Y-m-d');
            $slots = $professional->getAvailableSlotsForDate($date);
            if (!empty($slots)) {
                $availableDates[$date] = $slots;
            }
        }

        return view('professionals.show', compact('professional', 'availableDates'));
    }

    // Professional's own profile management
    public function create()
    {
        $categories = Category::all();
        return view('professionals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'bio'              => ['required', 'string', 'min:50', 'max:2000'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'location'         => ['required', 'string', 'max:255'],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'session_duration' => ['required', 'integer', 'in:15,30,45,60'],
            'photo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'specializations'  => ['nullable', 'string'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = Storage::disk('public')->put('professionals', $request->file('photo'));
        }

        $professional = Professional::create([
            'user_id'          => Auth::id(),
            'category_id'      => $validated['category_id'],
            'bio'              => $validated['bio'],
            'experience_years' => $validated['experience_years'],
            'location'         => $validated['location'],
            'consultation_fee' => $validated['consultation_fee'],
            'session_duration' => $validated['session_duration'],
            'photo'            => $photoPath,
            'specializations'  => $validated['specializations']
                ? array_map('trim', explode(',', $validated['specializations']))
                : null,
        ]);

        // Create default availability (Mon-Fri, 9am-5pm)
        foreach ([1, 2, 3, 4, 5] as $day) {
            Availability::create([
                'professional_id' => $professional->id,
                'day_of_week'     => $day,
                'start_time'      => '09:00',
                'end_time'        => '17:00',
            ]);
        }

        return redirect()->route('professional.dashboard')
            ->with('success', 'Professional profile created successfully!');
    }

    public function edit(Professional $professional)
    {
        $this->authorize('update', $professional);
        $categories = Category::all();
        return view('professionals.edit', compact('professional', 'categories'));
    }

    public function update(Request $request, Professional $professional)
    {
        $this->authorize('update', $professional);

        $validated = $request->validate([
            'category_id'      => ['required', 'exists:categories,id'],
            'bio'              => ['required', 'string', 'min:50', 'max:2000'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'location'         => ['required', 'string', 'max:255'],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'session_duration' => ['required', 'integer', 'in:15,30,45,60'],
            'photo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'specializations'  => ['nullable', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            if ($professional->photo) {
                Storage::disk('public')->delete($professional->photo);
            }
            $validated['photo'] = Storage::disk('public')->put('professionals', $request->file('photo'));
        }

        if (isset($validated['specializations'])) {
            $validated['specializations'] = array_map('trim', explode(',', $validated['specializations']));
        }

        $professional->update($validated);

        return redirect()->route('professional.dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy(Professional $professional)
    {
        $this->authorize('delete', $professional);
        $professional->delete();
        return redirect()->route('home')->with('success', 'Profile deleted.');
    }
}
