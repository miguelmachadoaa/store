<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        // Obtener la configuración o crear una vacía si no existe
        $setting = Setting::first() ?? new Setting;

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024', // 1MB Max
            'address' => 'required|string',
            'phone' => 'required|string',
            'rif' => 'required|string',
            'email' => 'required|email',
            'currency_preference' => 'required|in:usd,bs,both',
            'use_brevo' => 'nullable|boolean',
        ]);

        $setting = Setting::first();

        // Si no existe, lo creamos
        if (! $setting) {
            $setting = new Setting;
        }

        $data = $request->except('logo');

        // Manejo de Logo
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior si existe
            if ($setting->logo) {
                Storage::delete('public/'.$setting->logo);
            }
            // Guardar nuevo
            $path = $request->file('logo')->store('settings', 'public');
            $data['logo'] = $path;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Configuración actualizada correctamente.');
    }
}
