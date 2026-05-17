<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        return view('home');
    }

    public function fullPlan()
    {
        return view('plans.full');
    }

    public function fullPlanSubmit(Request $request)
    {
        $validated = $request->validate([
            'institution_name'  => 'required|string|max:255',
            'institution_type'  => 'required|string|max:100',
            'contact_name'      => 'required|string|max:255',
            'contact_email'     => 'required|email|max:255',
            'contact_phone'     => 'nullable|string|max:50',
            'user_count'        => 'required|string|max:50',
            'features'          => 'nullable|string|max:2000',
            'comments'          => 'nullable|string|max:2000',
        ]);

        // TODO: store in DB or send email notification
        // For now, redirect with success message
        return redirect()->route('plans.full')->with('success', '¡Solicitud enviada correctamente! Nos pondremos en contacto contigo pronto.');
    }
}
