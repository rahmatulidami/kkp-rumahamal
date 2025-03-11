<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    private $faqs = [
        [
            'question' => 'Bagaimana cara melakukan donasi?',
            'answer' => 'Anda dapat melakukan donasi melalui halaman donasi kami dengan berbagai metode pembayaran yang tersedia.',
            'steps' => []
        ],
        [
            'question' => 'Bagaimana cara mendapatkan laporan donasi?',
            'answer' => 'Laporan donasi akan dikirim ke email Anda setiap bulan atau bisa diunduh di dashboard pengguna.',
            'steps' => []
        ],
        [
            'question' => 'Bagaimana cara login?',
            'answer' => 'Ikuti langkah-langkah berikut untuk login:',
            'steps' => [
                [
                    'text' => 'Buka halaman login di website kami.',
                    'image' => 'assets/img/faq/halamanhome.png'

                ],
                [
                    'text' => 'Masukkan email dan password Anda.',
                    'image' => 'images/login-step2.png'
                ],
                [
                    'text' => 'Klik tombol login untuk masuk.',
                    'image' => 'images/login-step3.png'
                ]
            ]
        ]
    ];

    public function index()
    {
        return view('bantuan.bantuan', ['faqs' => $this->faqs]);
    }

    public function show($id)
    {
        if (!isset($this->faqs[$id])) {
            abort(404);
        }

        return view('bantuan.show', ['faq' => $this->faqs[$id]]);
    }
}
