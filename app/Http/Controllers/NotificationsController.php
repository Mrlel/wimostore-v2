<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Notifications_stock;
use \Illuminate\Support\optional;

class NotificationsController extends Controller
{
    public function notification(){
        // Afficher toutes les notifications (lues et non lues)
        $notifications = Notifications_stock::where('cabine_id', auth()->user()->cabine_id)
        ->latest()
        ->get();
        return view('notifications', compact('notifications'));
    }

    public function markAllAsRead(Request $request)
    {
        // Marquer toutes les notifications non lues comme lues
        Notifications_stock::where('cabine_id', auth()->user()->cabine_id)
            ->where('vu', false)
            ->update(['vu' => true]);
        
        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    }

    public function markAsRead($id)
    {
        $notification = Notifications_stock::where('cabine_id', auth()->user()->cabine_id)
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->update(['vu' => true]);
            return redirect()->back()->with('success', 'Notification marquée comme lue');
        }

        return redirect()->back()->with('error', 'Notification non trouvée');
    }

    public function destroy($id)
    {
        $notification = Notifications_stock::where('cabine_id', auth()->user()->cabine_id)
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Notification supprimée avec succès');
        }

        return redirect()->back()->with('error', 'Notification non trouvée');
    }
}