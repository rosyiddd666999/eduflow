<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CpanelUploadService
{
    public function upload($file)
    {
        $url = env('CPANEL_UPLOAD_URL');

        // Jangan gunakan fallback ke local storage jika tujuan utama adalah cPanel
        if (!$url) {
            throw new \Exception('CPANEL_UPLOAD_URL belum dikonfigurasi di .env');
        }

        try {
            $response = Http::timeout(300) // Naikkan timeout ke 5 menit
                ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post($url);

            if ($response->successful()) {
                $data = $response->json();
                // Kembalikan hanya nama file, Filament akan menambahkan prefix folder sendiri
                return $data['file_name'];
            }

            // Lempar error agar muncul di UI Filament
            throw new \Exception('Gagal upload ke cPanel: ' . $response->body());

        } catch (\Exception $e) {
            // Log error untuk pengecekan detail
            \Log::error('Cpanel Upload Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
