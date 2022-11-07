<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'business_name' => 'E-Commerce',
            'email' => 'E-Commerce@mail.com',
            'phone' => '01090411577',
            'phone2' => '01090411577',
            'address' => 'E-Commerce Website Address',
            'twitter' => 'twitter.com',
            'facebook' => 'facebook.com',
            'youtube' => 'youtube.com',
            'instagram' => 'instagram.com',
            'pinterest' => 'pinterest.com',
            'dribbble' => 'dribbble.com',
            'currency'  => '$',
            'newLogo1' => 'defaultLogo1.png',
            'newLogo2' => 'defaultLogo2.png',
        ];
    }
}
