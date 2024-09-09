<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->truncate();
$data = [
    [
        'key' => 'egypt_address',
        'value' => 'egypt',
        'type' => 'text'
    ],
    [
        'key' => 'qatar_address',
        'value' => 'We are currently under maintenance. Please check back later.',
        'type' => 'text'
    ],
    [
        'key' => 'phone',
        'value' => '123456789',
        'type' => 'text'
    ],
    [
        'key' => 'whatsapp',
        'value' => '123456789',
        'type' => 'text'
    ],
    [
        'key' => 'email',
        'value' => 'mail@mail.com',
        'type' => 'text'
    ],
    [
        'key' => 'facebook',
        'value' => 'https://facebook.com/bokitapp',
        'type' => 'text'
    ],
    [
        'key' => 'twitter',
        'value' => 'https://twitter.com/bokitapp',
        'type' => 'text'
    ],
    [
        'key' => 'instagram',
        'value' => 'https://instagram.com/bokitapp',
        'type' => 'text'
    ],
    [
        'key' => 'snapchat',
        'value' => 'https://snapchat.com/bokitapp',
        'type' => 'text'
    ],
    [
        'key' => 'telegram',
        'value' => 'https://telegram.com/bokitapp',
        'type' => 'text'
    ],
    [
        'key' => 'terms',
        'value' => 'data',
        'type' => 'textarea'
    ],
    [
        'key' => 'youtube',
        'value' => 'https://youtube.com/bokitapp',
        'type' => 'text'
    ],
    [
        'key' => 'logo',
        'value' => 'https://bokitapp.com/logo.png',
        'type' => 'image'
    ],
    [
        'key' => 'privacy',
        'value' => 'data',
        'type' => 'textarea',
    ],
];

DB::table('settings')->insert($data);
    }
}
