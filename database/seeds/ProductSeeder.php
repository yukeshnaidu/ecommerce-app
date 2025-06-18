<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\SubCategory;
use App\Product;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Truncate all tables first
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        SubCategory::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();
        
        $availableImages = [
            '1749151819.jpg',
            '1749213059.jpg',
            '1749213138.jpg',
            '1749330042.jpg',
        ];
        
        // Real-world categories with hierarchical subcategories
        $categories = [
            'Electronics' => [
                'Mobile Phones' => [
                    'Smartphones' => [
                        'Android Phones',
                        'iPhones',
                        'Refurbished Phones'
                    ],
                    'Feature Phones'
                ],
                'Laptops' => [
                    'Gaming Laptops',
                    'Business Laptops',
                    'Ultrabooks' => [
                        'Windows Ultrabooks',
                        'MacBooks'
                    ]
                ],
                'TVs' => [
                    'Smart TVs',
                    '4K UHD TVs',
                    'OLED TVs'
                ]
            ],
            'Home & Kitchen' => [
                'Furniture' => [
                    'Living Room' => [
                        'Sofas',
                        'Coffee Tables',
                        'TV Stands'
                    ],
                    'Bedroom' => [
                        'Beds',
                        'Wardrobes',
                        'Dressing Tables'
                    ]
                ],
                'Appliances' => [
                    'Kitchen Appliances' => [
                        'Microwaves',
                        'Blenders',
                        'Coffee Makers'
                    ],
                    'Cleaning Appliances' => [
                        'Vacuum Cleaners',
                        'Steam Mops'
                    ]
                ]
            ],
            'Fashion' => [
                'Men' => [
                    'Clothing' => [
                        'T-Shirts',
                        'Jeans',
                        'Shirts'
                    ],
                    'Footwear' => [
                        'Sneakers',
                        'Formal Shoes',
                        'Sandals'
                    ]
                ],
                'Women' => [
                    'Clothing' => [
                        'Dresses',
                        'Tops',
                        'Jeans'
                    ],
                    'Footwear' => [
                        'Heels',
                        'Flats',
                        'Boots'
                    ]
                ]
            ],
            'Books' => [
                'Fiction' => [
                    'Science Fiction',
                    'Fantasy',
                    'Mystery' => [
                        'Crime Thrillers',
                        'Detective Stories'
                    ]
                ],
                'Non-Fiction' => [
                    'Biographies',
                    'Self-Help',
                    'Business' => [
                        'Management',
                        'Entrepreneurship'
                    ]
                ]
            ]
        ];

        foreach ($categories as $categoryName => $subCategories) {
            $category = Category::create(['name' => $categoryName]);
            echo "Created category: {$category->name}\n";

            $this->createSubcategories($category, $subCategories, 1);
        }

        // Create products and assign to random subcategories (all levels)
        $subCategories = SubCategory::all();
        
        for ($i = 0; $i < 300; $i++) {
            $subCategory = $subCategories->random();
            
            Product::create([
                'name' => $this->generateProductName($subCategory->name, $faker),
                'category_id' => $subCategory->category_id,
                'sub_category_id' => $subCategory->id,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 5, 1000),
                'quantity' => $faker->numberBetween(0, 100),
                'image' => $availableImages[array_rand($availableImages)]
            ]);
        }

        echo "Created 100 products assigned to random subcategories.\n";
    }

    /**
     * Recursively create subcategories
     */
    protected function createSubcategories($parentCategory, $subCategories, $level, $parentSubCategory = null)
    {
        foreach ($subCategories as $name => $children) {
            // Handle both associative arrays (with children) and simple arrays
            $subCategoryName = is_array($children) ? $name : $children;
            
            $subCategory = SubCategory::create([
                'name' => $subCategoryName,
                'category_id' => $parentCategory->id,
                'parent_id' => $parentSubCategory ? $parentSubCategory->id : null
            ]);
            
            echo str_repeat('  ', $level) . "├── Created L{$level} subcategory: {$subCategory->name}\n";
            
            // If this subcategory has children, recurse
            if (is_array($children)) {
                $this->createSubcategories($parentCategory, $children, $level + 1, $subCategory);
            }
        }
    }

    /**
     * Generate realistic product names based on subcategory
     */
    protected function generateProductName($subCategory, $faker)
    {
        $brands = [
            'Electronics' => ['Samsung', 'Apple', 'Sony', 'LG', 'OnePlus'],
            'Home & Kitchen' => ['IKEA', 'Whirlpool', 'KitchenAid', 'Hamilton Beach'],
            'Fashion' => ['Nike', 'Adidas', 'Levi\'s', 'Zara', 'H&M'],
            'Books' => ['Penguin', 'HarperCollins', 'Simon & Schuster']
        ];
        
        $categoryType = $this->getCategoryType($subCategory);
        $brand = $faker->randomElement($brands[$categoryType] ?? ['Generic']);
        
        $descriptors = [
            'Electronics' => ['Pro', 'Max', 'Plus', 'Ultra', 'HD'],
            'Home & Kitchen' => ['Deluxe', 'Premium', 'Professional', 'Compact'],
            'Fashion' => ['Classic', 'Modern', 'Slim Fit', 'Relaxed Fit'],
            'Books' => ['Special Edition', 'Anniversary Edition', 'Bestseller']
        ];
        
        $descriptor = $faker->randomElement($descriptors[$categoryType] ?? ['']);
        
        return "{$brand} {$subCategory} {$descriptor}";
    }
    
    protected function getCategoryType($subCategory)
    {
        if (str_contains($subCategory, 'Phone') || str_contains($subCategory, 'TV') || str_contains($subCategory, 'Laptop')) {
            return 'Electronics';
        } elseif (str_contains($subCategory, 'Furniture') || str_contains($subCategory, 'Appliance')) {
            return 'Home & Kitchen';
        } elseif (str_contains($subCategory, 'Clothing') || str_contains($subCategory, 'Footwear')) {
            return 'Fashion';
        }
        return 'Books';
    }
}