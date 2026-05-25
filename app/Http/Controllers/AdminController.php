<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users'         => User::where('role', 'user')->count(),
            'professionals' => Professional::count(),
            'appointments'  => Appointment::count(),
            'categories'    => Category::count(),
            'revenue'       => Appointment::whereIn('status', ['confirmed', 'completed'])->sum('fee'),
            'pending'       => Appointment::where('status', 'pending')->count(),
        ];

        $recentAppointments = Appointment::with(['user', 'professional.user', 'professional.category'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments'));
    }

    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.users', compact('users'));
    }

    public function professionals(Request $request)
    {
        $query = Professional::with(['user', 'category']);
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        $professionals = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();
        return view('admin.professionals', compact('professionals', 'categories'));
    }

    public function toggleProfessional(Professional $professional)
    {
        $professional->update(['is_active' => !$professional->is_active]);
        $status = $professional->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Professional {$status} successfully.");
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin accounts.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($user) {
            // Delete appointments where this user is the client
            $user->appointments()->delete();

            // Delete reviews left by this user (if any exist)
            if (method_exists($user, 'reviews')) {
                $user->reviews()->delete();
            }

            // If user is a professional, clean up their records
            if ($user->professional) {
                // Delete all appointments associated with this professional
                \App\Models\Appointment::where('professional_id', $user->professional->id)->delete();
                $user->professional()->delete();
            }

            $user->delete();
        });

        return back()->with('success', 'User and all related data deleted successfully.');
    }

    public function categories()
    {
        $categories = Category::all()->map(function ($category) {
            $category->professionals_count = Professional::where('category_id', $category->id)->count();
            return $category;
        });
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string',
            'color'       => 'nullable|string',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => \Str::slug($request->name),
            'description' => $request->description,
            'icon'        => $request->icon ?? 'briefcase',
            'color'       => $request->color ?? '#6366f1',
        ]);

        return back()->with('success', 'Category created.');
    }

    public function appointments(Request $request)
    {
        $query = Appointment::with(['user', 'professional.user']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $appointments = $query->latest()->paginate(20)->withQueryString();
        return view('admin.appointments', compact('appointments'));
    }
}
