<?php

namespace App\Services;

use GuzzleHttp\Client;
use RuntimeException;

class RaspberryPiClient
{
    public function send(array $command)
    {
        $baseUrl = rtrim((string) config('pingpong.raspberry_url'), '/');
        $token = (string) config('pingpong.raspberry_token');

        if ($baseUrl === '' || $token === '') {
            throw new RuntimeException('Koneksi Raspberry Pi belum dikonfigurasi. Atur RASPBERRY_PI_URL dan RASPBERRY_PI_TOKEN di .env.');
        }

        if (strpos($baseUrl, 'http://') !== 0 && strpos($baseUrl, 'https://') !== 0) {
            throw new RuntimeException('Alamat Raspberry Pi harus menggunakan http:// atau https://.');
        }

        $client = new Client([
            'timeout' => max(1, (int) config('pingpong.request_timeout', 3)),
            'connect_timeout' => 2,
            'http_errors' => false,
        ]);

        try {
            $response = $client->post($baseUrl . '/api/control', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $command,
            ]);
        } catch (\Exception $e) {
            throw new RuntimeException('Raspberry Pi tidak dapat dijangkau di jaringan lokal. Pastikan perangkat menyala dan alamat IP benar.');
        }

        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            throw new RuntimeException('Raspberry Pi menolak perintah (HTTP ' . $status . '). Periksa token dan layanan pengendali.');
        }

        $body = (string) $response->getBody();
        $decoded = json_decode($body, true);
        return is_array($decoded) ? $decoded : ['accepted' => true];
    }
}
