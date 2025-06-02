<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Store;
use App\Models\ProductCategory;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $User = [
            [
            'user_id' => 'OW001',
            'name' => 'Errico',
            'phone_number'=>'081210015352',
            'role'=>'Owner',
            'status'=>1,
            'email' => 'owner@gmail.com',
            'password' =>Hash::make('Azuko123!'),
            ],
        ];

        foreach ($User as $user) {
            User::create($user);
        }
        $Store = [
            [
            'store_id' => 'ST001',
            'user_id' => 'OW001',
            'store_name' => 'BrewCash',
            'store_address' => 'Jl. Raya Kuta, Kuta, Badung, Bali',
            'store_icon' => 'backend/images/deficon.png',
            ],
        ];

        foreach ($Store as $store) {
            Store::create($store);
        }
        $Category = [
            [
            'category_name' => 'Add Ons'
            ],
        ];

        foreach ($Category as $category) {
            ProductCategory::create($category);
        }
    }
}
