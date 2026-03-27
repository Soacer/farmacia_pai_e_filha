<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Enums\CategorySubclass;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Percorre todas as subclasses definidas no seu Enum
        foreach (CategorySubclass::cases() as $subclass) {
            
            Category::create([
                'class'    => $subclass->categoryClass()->label(), 
                'subclass' => $subclass->label(),
                'isActive' => true,
            ]);
        }
    }
}