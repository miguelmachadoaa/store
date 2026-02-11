<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()
            ->ordered()
            ->get();

        return view('services.index', compact('services'));
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->with([
                'sections' => function ($query) {
                    $query->orderBy('order');
                },
                'testimonials',
            ])
            ->firstOrFail();

        return view('services.show', compact('service'));
    }
}
