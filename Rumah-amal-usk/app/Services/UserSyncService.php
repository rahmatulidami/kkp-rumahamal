<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UserSyncService
{
    /**
     * Sinkronisasi user Laravel ke WordPress.
     */
    public function syncToWordPress($user, $plainPassword)
    {
        // Periksa apakah user sudah ada di WordPress
        $response = Http::withBasicAuth(env('WORDPRESS_USERNAME'), env('WORDPRESS_APPLICATION_PASSWORD'))
            ->get('https://rumahamal.usk.ac.id/api-staging/wp-json/wp/v2/users', [
                'search' => $user->email, // Cari user berdasarkan email
            ]);

        if ($response->successful() && count($response->json()) > 0) {
            // User sudah ada di WordPress, ambil ID-nya
            $wpUser = $response->json()[0];
            $user->update(['wp_user_id' => $wpUser['id']]);
        } else {
            // Buat user baru di WordPress
            $response = Http::withBasicAuth(env('WORDPRESS_USERNAME'), env('WORDPRESS_APPLICATION_PASSWORD'))
                ->post('https://rumahamal.usk.ac.id/api-staging/wp-json/wp/v2/users', [
                    'username' => $user->name,
                    'email' => $user->email,
                    'name' => $user->name,
                    'password' => $plainPassword, // Kirim password plaintext
                ]);

            if ($response->successful()) {
                $wpUser = $response->json();
                $user->update(['wp_user_id' => $wpUser['id']]);
            } else {
                throw new \Exception('Failed to sync user to WordPress: ' . $response->body());
            }
        }
    }
}