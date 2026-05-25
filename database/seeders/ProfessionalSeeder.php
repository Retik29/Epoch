<?php

namespace Database\Seeders;

use App\Models\Availability;
use App\Models\Category;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfessionalSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        if ($categories->isEmpty()) {
            return;
        }

        $names = [
            'Dr. Arjun Nair', 'Dr. Pooja Pillai', 'Prof. Sameer Khan', 'Adv. Neha Desai',
            'Mr. Kiran Rao', 'Dr. Anjali Singh', 'Dr. Vivek Joshi', 'Ms. Rekha Thomas',
            'Prof. Suresh Iyer', 'Dr. Lakshmi Reddy', 'Mr. Aditya Bose', 'Adv. Preeti Menon',
            'Dr. Rajesh Gupta', 'Prof. Nidhi Shah', 'Mr. Harish Verma',
        ];

        $photos = [
            'Dr. Arjun Nair' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?q=80&w=600&auto=format&fit=crop',
            'Dr. Pooja Pillai' => 'https://images.unsplash.com/photo-1594824813573-246434de83fb?q=80&w=600&auto=format&fit=crop',
            'Prof. Sameer Khan' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=600&auto=format&fit=crop',
            'Adv. Neha Desai' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop',
            'Mr. Kiran Rao' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=600&auto=format&fit=crop',
            'Dr. Anjali Singh' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=600&auto=format&fit=crop',
            'Dr. Vivek Joshi' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?q=80&w=600&auto=format&fit=crop',
            'Ms. Rekha Thomas' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=600&auto=format&fit=crop',
            'Prof. Suresh Iyer' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=600&auto=format&fit=crop',
            'Dr. Lakshmi Reddy' => 'https://images.unsplash.com/photo-1614608682850-e0d6ed316d47?q=80&w=600&auto=format&fit=crop',
            'Mr. Aditya Bose' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=600&auto=format&fit=crop',
            'Adv. Preeti Menon' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=600&auto=format&fit=crop',
            'Dr. Rajesh Gupta' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?q=80&w=600&auto=format&fit=crop',
            'Prof. Nidhi Shah' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?q=80&w=600&auto=format&fit=crop',
            'Mr. Harish Verma' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=600&auto=format&fit=crop',
        ];

        $categoryMapping = [
            'Dr. Arjun Nair' => 'doctors',
            'Dr. Pooja Pillai' => 'doctors',
            'Prof. Sameer Khan' => 'tutors',
            'Adv. Neha Desai' => 'lawyers',
            'Mr. Kiran Rao' => 'consultants',
            'Dr. Anjali Singh' => 'doctors',
            'Dr. Vivek Joshi' => 'therapists',
            'Ms. Rekha Thomas' => 'therapists',
            'Prof. Suresh Iyer' => 'tutors',
            'Dr. Lakshmi Reddy' => 'doctors',
            'Mr. Aditya Bose' => 'fitness-coaches',
            'Adv. Preeti Menon' => 'lawyers',
            'Dr. Rajesh Gupta' => 'doctors',
            'Prof. Nidhi Shah' => 'tutors',
            'Mr. Harish Verma' => 'consultants',
        ];

        foreach ($names as $i => $name) {
            $email = strtolower(str_replace([' ', '.'], ['_', ''], $name)) . $i . '@epoch.com';
            
            $slug = $categoryMapping[$name] ?? 'doctors';
            $category = $categories->firstWhere('slug', $slug) ?? $categories->random();

            $user = User::firstOrCreate(['email' => $email], [
                'name'     => $name,
                'password' => Hash::make('password'),
                'role'     => 'professional',
            ]);

            $professional = Professional::updateOrCreate(['user_id' => $user->id], [
                'category_id'      => $category->id,
                'bio'              => "Experienced professional with over " . rand(3, 20) . " years in the field. "
                    . "Committed to providing high-quality, personalized service to every client. "
                    . "Specializes in comprehensive consultations and tailored solutions.",
                'experience_years' => rand(3, 20),
                'location'         => collect(['Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Hyderabad', 'Pune', 'Kolkata'])->random() . ', India',
                'photo'            => $photos[$name] ?? null,
                'consultation_fee' => collect([300, 500, 600, 750, 800, 1000, 1200, 1500])->random(),
                'session_duration' => collect([30, 45, 60])->random(),
                'is_active'        => true,
                'rating'           => round(rand(35, 50) / 10, 1),
                'total_reviews'    => rand(5, 120),
                'specializations'  => collect(['Consultation', 'Follow-up Care', 'Preventive', 'Diagnosis', 'Advisory'])->random(rand(2, 3))->values()->toArray(),
            ]);

            // Availability: Mon-Fri
            for ($day = 1; $day <= 5; $day++) {
                Availability::firstOrCreate([
                    'professional_id' => $professional->id,
                    'day_of_week'     => $day,
                ], [
                    'start_time' => collect(['08:00', '09:00', '10:00'])->random(),
                    'end_time'   => collect(['16:00', '17:00', '18:00'])->random(),
                    'is_active'  => true,
                ]);
            }
        }
    }
}
