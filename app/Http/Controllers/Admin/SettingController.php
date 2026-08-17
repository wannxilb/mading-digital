<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Mading Digital'),
            'site_tagline' => Setting::get('site_tagline', 'Majalah Dinding Sekolah'),
            'site_description' => Setting::get('site_description', 'Majalah dinding digital sekolah: pengumuman, berita, karya siswa, agenda, dan prestasi.'),
            'favicon_path' => Setting::get('favicon_path'),
            'logo_path' => Setting::get('logo_path'),
            'hero_image_path' => Setting::get('hero_image_path'),
            'contact_email' => Setting::get('contact_email'),
            'contact_whatsapp' => Setting::get('contact_whatsapp'),
            'contact_address' => Setting::get('contact_address'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:60'],
            'site_tagline' => ['nullable', 'string', 'max:100'],
            'site_description' => ['nullable', 'string', 'max:255'],
            'favicon' => ['nullable', 'image', 'mimes:ico,png,svg', 'max:2048'],
            'logo' => ['nullable', 'image', 'mimes:png,svg,jpg,jpeg', 'max:2048'],
            'hero_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_whatsapp' => ['nullable', 'string', 'max:20'],
            'contact_address' => ['nullable', 'string', 'max:255'],
        ]);

        $updates = [
            'site_name' => $data['site_name'],
            'site_tagline' => $data['site_tagline'] ?? null,
            'site_description' => $data['site_description'] ?? null,
            'contact_email' => $data['contact_email'] ?? null,
            'contact_whatsapp' => $data['contact_whatsapp'] ?? null,
            'contact_address' => $data['contact_address'] ?? null,
        ];

        if ($request->hasFile('favicon')) {
            $old = Setting::get('favicon_path');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $updates['favicon_path'] = $request->file('favicon')->store('settings', 'public');
        }

        if ($request->hasFile('logo')) {
            $old = Setting::get('logo_path');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $updates['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('hero_image')) {
            $old = Setting::get('hero_image_path');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $updates['hero_image_path'] = $request->file('hero_image')->store('settings', 'public');
        }

        Setting::setMany($updates);

        return back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
