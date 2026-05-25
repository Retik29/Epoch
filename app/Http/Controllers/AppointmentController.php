<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Mail\AppointmentCancelledMail;
use App\Mail\AppointmentConfirmedMail;
use App\Models\Appointment;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['professional.user', 'professional.category'])
            ->where('user_id', Auth::id())
            ->orderByDesc('appointment_date')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function create(Request $request)
    {
        $professional = Professional::with(['user', 'category', 'availabilities'])->findOrFail($request->professional_id);
        $date = $request->get('date', now()->addDay()->format('Y-m-d'));
        $slots = $professional->getAvailableSlotsForDate($date);

        return view('appointments.create', compact('professional', 'date', 'slots'));
    }

    public function store(AppointmentRequest $request)
    {
        $professional = Professional::findOrFail($request->professional_id);

        $appointment = Appointment::create([
            'user_id'             => Auth::id(),
            'professional_id'     => $request->professional_id,
            'appointment_date'    => $request->appointment_date,
            'time_slot'           => $request->time_slot,
            'notes'               => $request->notes,
            'fee'                 => $professional->consultation_fee,
            'status'              => 'pending',
            'payment_status'      => 'paid',
            'razorpay_payment_id' => 'demo_pay_' . uniqid(),
            'razorpay_signature'  => 'demo_sig_' . uniqid(),
            'razorpay_order_id'   => 'demo_order_' . uniqid(),
        ]);

        // Eager-load relationships needed by the mail template
        $appointment->load(['user', 'professional.user', 'professional.category']);

        // Send confirmation email (queued)
        try {
            Mail::to(Auth::user()->email)->queue(
                new AppointmentConfirmedMail($appointment)
            );
        } catch (\Exception $e) {
            // Fail silently — appointment is still created
        }

        return redirect()->route('appointments.show', $appointment)
            ->with('success', __('messages.appointment_booked'));
    }

    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        $appointment->load(['professional.user', 'professional.category', 'user', 'review']);

        return view('appointments.show', compact('appointment'));
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $this->authorize('cancel', $appointment);

        if (!$appointment->canBeCancelledByUser()) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $appointment->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        // Notify the professional
        try {
            Mail::to($appointment->professional->user->email)->queue(
                new AppointmentCancelledMail($appointment)
            );
        } catch (\Exception $e) {}

        return redirect()->route('appointments.index')
            ->with('success', __('messages.appointment_cancelled'));
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted.');
    }
}
