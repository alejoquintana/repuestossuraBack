<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          factory(App\Category::class)->create(['name'=>'sets materos','slug'=>'sets_materos']);
          factory(App\Category::class)->create(['name'=>'diseño y deco','slug'=>'diseno_y_deco']);
       
    }
}
