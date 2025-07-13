<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;

class SupportTicketController extends Controller
{
    public function index()
    {
        // Logic to display support tickets
        return view('admin.support-ticket.index');
    }

    public function show(SupportTicket $ticket)
    {
        // Logic to display a specific support ticket
        return view('admin.support-ticket.show', ['ticket' => $ticket]);
    }

    public function create()
    {
        // Logic to show the form for creating a new support ticket
        return view('public.help-center.support');
    }
}
