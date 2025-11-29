<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('receiver_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $layout = 'plantillas.dashboard_recepcionista'; // Default
        $userType = auth()->user()->typeUser_id;

        if ($userType == 2) {
            $layout = 'plantillas.dashboard_medico';
        } elseif ($userType == 3) {
            $layout = 'plantillas.dashboard_paciente';
        }

        return view('NOTIFICATIONS.index', compact('notifications', 'layout'));
    }

    public function markAsRead($id)
    {
        try {
            $notification = Notification::findOrFail($id);

            if ($notification->receiver_id != auth()->user()->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $notification->status = 'read';
            $notification->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getUnreadCount()
    {
        try {
            $count = Notification::where('receiver_id', auth()->user()->id)
                ->where('status', 'pending')
                ->count();

            return response()->json(['success' => true, 'count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'count' => 0]);
        }
    }

    public function sendManualReminder(Request $request)
    {
        try {
            $appointmentId = $request->input('appointment_id');
            // Assuming we receive appointment ID, we need to fetch it to get the doctor
            // But wait, the request might just have the doctor ID or we need to look it up.
            // Let's assume we get the appointment ID.
            
            $appointment = \App\Models\appointment::with('doctor.user', 'patient.user')->findOrFail($appointmentId);

            if (!$appointment->doctor || !$appointment->doctor->user) {
                return response()->json(['success' => false, 'message' => 'No hay médico asignado a esta cita.'], 404);
            }

            Notification::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $appointment->doctor->user->id,
                'user_role' => 'medico',
                'title' => 'Recordatorio de Cita',
                'message' => "Recordatorio: Tiene una cita con el paciente " . ($appointment->patient->user->name ?? $appointment->patient->temporary_name) . " el " . $appointment->appointment_date . " a las " . $appointment->appointment_time,
                'status' => 'pending'
            ]);

            // Notify Patient
            if ($appointment->patient && $appointment->patient->user) {
                Notification::create([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $appointment->patient->user->id,
                    'user_role' => 'paciente',
                    'title' => 'Recordatorio de Cita',
                    'message' => "Recordatorio: Tiene una cita con el Dr. " . ($appointment->doctor->user->name ?? 'Asignado') . " el " . $appointment->appointment_date . " a las " . $appointment->appointment_time,
                    'status' => 'pending'
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Recordatorio enviado al médico.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al enviar recordatorio: ' . $e->getMessage()], 500);
        }
    }

    public function getRecent()
    {
        try {
            $notifications = Notification::where('receiver_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return response()->json(['success' => true, 'notifications' => $notifications]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'notifications' => []], 500);
        }
    }
}
