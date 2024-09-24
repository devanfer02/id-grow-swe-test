<?php

namespace Database\Seeders;

use App\Models\MutationTypes;
use App\Models\ItemCategory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Furniture',
            'Stationery',
            'Clothing',
            'Food & Beverage'
        ];
        $mutations = [
            'Addition',
            'Subtraction',
        ];

        foreach($categories as $category) {
            ItemCategory::insert([
                'name' => $category
            ]);
        }

        foreach($mutations as $mutation) {
            MutationTypes::insert([
                'name' => $mutation
            ]);
        }
    }
}
