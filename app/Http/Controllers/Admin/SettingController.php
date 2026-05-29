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
        // 1. Validamos tanto tus campos originales como los nuevos del Linktree
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:1024', // 1MB Max
            'address' => 'required|string',
            'phone' => 'required|string',
            'rif' => 'required|string',
            'email' => 'required|email',
            'currency_preference' => 'required|in:usd,bs,both',
            'use_brevo' => 'nullable|boolean',

            // Nuevas reglas para la personalización del Linktree
            'linktree_logo' => 'nullable|image|max:1024', // 1MB Max
            'linktree_bg_type' => 'required|in:gradient,solid,image',
            'linktree_bg_color' => 'required|string|max:7', // Ej: #ffffff
            'linktree_bg_gradient_to' => 'required_if:linktree_bg_type,gradient|nullable|string|max:7',
            'linktree_button_bg' => 'required|string|max:50', // Hex o RGBA
            'linktree_button_text' => 'required|string|max:7',
            'linktree_bg_image' => 'nullable|image|max:2048', // 2MB Max para fondos
        ]);

        $setting = Setting::first();

        // Si no existe, lo creamos
        if (! $setting) {
            $setting = new Setting;
        }

        // Excluimos todos los archivos binarios del request para procesarlos manualmente
        $data = $request->except(['logo', 'linktree_logo', 'linktree_bg_image']);

        // Asegurar que use_brevo sea 0 si no viene en el request (al ser un checkbox/select estructurado)
        $data['use_brevo'] = $request->has('use_brevo') ? $request->input('use_brevo') : 0;

        // 2. Manejo del Logo de la Tienda (Tu lógica original manteniendo 'public/')
        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::delete('public/' . $setting->logo);
            }
            $path = $request->file('logo')->store('settings', 'public');
            $data['logo'] = $path;
        }

        // 3. Manejo del Logo Exclusivo de Linktree
        if ($request->hasFile('linktree_logo')) {
            if ($setting->linktree_logo) {
                Storage::delete('public/' . $setting->linktree_logo);
            }
            $path = $request->file('linktree_logo')->store('linktree', 'public');
            $data['linktree_logo'] = $path;
        }

        // 4. Manejo de la Imagen de Fondo de Linktree
        if ($request->hasFile('linktree_bg_image')) {
            if ($setting->linktree_bg_image) {
                Storage::delete('public/' . $setting->linktree_bg_image);
            }
            $path = $request->file('linktree_bg_image')->store('linktree/backgrounds', 'public');
            $data['linktree_bg_image'] = $path;
        }

        // 5. Guardado general usando fill
        $setting->fill($data);
        $setting->save();

        $path = $data['linktree_bg_image'];
        $from = storage_path('app/public/' . $path);
        $to = public_path('storage/' . $path);

        if (!file_exists(dirname($to))) {
            mkdir(dirname($to), 0775, true);
        }

        copy($from, $to);

        $path = $data['logo'];
        $from = storage_path('app/public/' . $path);
        $to = public_path('storage/' . $path);

        if (!file_exists(dirname($to))) {
            mkdir(dirname($to), 0775, true);
        }

        copy($from, $to);    

        // Redirecciona con tu sesión de éxito original
        return redirect()->route('admin.settings.edit')->with('success', 'Configuración actualizada correctamente.');
    }
}