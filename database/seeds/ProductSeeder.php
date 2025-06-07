<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\SubCategory;
use App\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        $availableImages = [
            '1749151819.jpg',
            '1749213059.jpg',
            '1749213138.jpg',
            '1749330042.jpg',
        ];
        
        $categories = ['Books', 'Toys'];
        
        foreach ($categories as $categoryName) {
            $category = Category::create([
                'name' => $categoryName
            ]);

            // Create 2-4 subcategories for each category
            $subCategoryCount = rand(2, 4);
            for ($i = 1; $i <= $subCategoryCount; $i++) {
                SubCategory::create([
                    'name' => $categoryName . ' Subcategory ' . $i,
                    'category_id' => $category->id
                ]);
            }
        }  

        $subCategories = SubCategory::all();
        
        for ($i = 0; $i < 100; $i++) {
            $subCategory = $subCategories->random();
            
            Product::create([
                'name' => $faker->words(3, true),
                'category_id' => $subCategory->category_id,
                'sub_category_id' => $subCategory->id,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 5, 1000),
                'quantity' => $faker->numberBetween(0, 100),
                'image' => $availableImages[array_rand($availableImages)]
            ]);
        }
    }
}
