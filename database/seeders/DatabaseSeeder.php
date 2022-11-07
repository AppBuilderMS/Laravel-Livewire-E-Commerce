<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(1)->create();
         $this->call(AdminSeeder::class);
         $this->call(SettingSeeder::class);
         \App\Models\Category::factory(6)->create();
         \App\Models\Subcategory::factory(18)->create();
         \App\Models\Product::factory(60)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

//        $this->call(ProductsTableSeeder::class);

        $allFeatured = Product::inRandomOrder()->limit(12)->get();
        foreach ($allFeatured as $featured){
            $featured->update([
                'featured' => true
            ]);
        }

        $productsOnSale = Product::inRandomOrder()->limit(12)->get();
        foreach ($productsOnSale as $onSale){
            $salePrice = $onSale->regular_price - ($onSale->regular_price * 0.20);
            $onSale->update([
               'sale_price' => $salePrice
            ]);
        }

        $pAttributes = ['Size', 'Color',];
        foreach ($pAttributes as $pAttribute){
            ProductAttribute::create([
                'name' => $pAttribute
            ]);
        }

        $allProducts = Product::all();
        $values = ['50', '60', '70', 'White', 'Black', 'Red'];
        $pai = ['1', '1', '1', '2', '2', '2'];
        foreach ($allProducts as $product){
            for ($i=0, $iMax = count($values); $i < $iMax; $i++){
                AttributeValue::create([
                    'value' => $values[$i],
                    'product_attribute_id' => $pai[$i],
                    'product_id' => $product->id
                ]);
            }
        }
    }
}
