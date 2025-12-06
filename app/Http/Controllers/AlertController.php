<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::where('read', false)->orderBy('created_at', 'desc')->get();
        $readAlerts = Alert::where('read', true)->orderBy('created_at', 'desc')->limit(10)->get();

        return view('alerts.index', compact('alerts', 'readAlerts'));
    }

    public function markAsRead(Alert $alert)
    {
        $alert->update(['read' => true]);
        return back()->with('success', 'Alerta marcado como lido!');
    }

    public function markAllAsRead()
    {
        Alert::where('read', false)->update(['read' => true]);
        return back()->with('success', 'Todos os alertas marcados como lidos!');
    }

    public function delete(Alert $alert)
    {
        $alert->delete();
        return back()->with('success', 'Alerta eliminado!');
    }

    public function getUnreadCount()
    {
        return Alert::where('read', false)->count();
    }
}
