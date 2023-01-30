<?php

use Illuminate\Database\Seeder;
use App\Order;
use App\OrderItem;
use App\Survey;
use App\Role;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $OrderItems = OrderItem::all();
        foreach ($OrderItems as $item) {
            $item->created_at = '20'.random_int(21,22).'-'.random_int(1,3).'-'.random_int(1,28).' 09:27:21';
            $item->save();
        }
    }
}
