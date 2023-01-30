<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = new User();
        $super->name = 'Alejo';
        $super->email = 'alejo@super.com';
        $super->password = bcrypt('alejo');
        $super->role_id = 1;
        $super->save(); 
        
        $admin = new User();
        $admin->name = 'Alejo';
        $admin->email = 'alejo@admin.com';
        $admin->password = bcrypt('alejo');
        $admin->role_id = 2;
        $admin->save(); 

        /* 
        $super = new User();
        $super->name = 'Rodrigo';
        $super->email = 'rsbertoa90@gmail.com';
        $super->password = bcrypt('rsbertoa90');
        $super->role_id = 1;
        $super->save(); 

        $super = new User();
        $super->name = 'Rodrigo';
        $super->email = 'rsbertoa90@gmail.com';
        $super->password = bcrypt('rsbertoa90');
        $super->role_id = 1;
        $super->save(); 
        
        $super = new User();
        $super->name = 'Gise';
        $super->email = 'roominagii@gmail.com';
        $super->password = bcrypt('roominagii');
        $super->role_id = 1;
        $super->save();

        $manager = new User();
        $manager->name = 'Pedidos online';
        $manager->email = 'pedidosonline@suspensionlujan.com';
        $manager->password = bcrypt('suspensionlujan');
        $manager->role_id =2 ;
        $manager->save();

        $super = new User();
        $super->name = 'alejo';
        $super->email = 'alejo@super.com';
        $super->password = bcrypt('alejo');
        $super->role_id = 1 ;
        $super->save();

        $admin = new User();
        $admin->name = 'alejo';
        $admin->email = 'alejo@admin.com';
        $admin->password = bcrypt('alejo');
        $admin->role_id = 2;
        $admin->save();
       
        for ($i=0; $i < 50; $i++) { 
            $admin = new User();
            $admin->name = "User $i";
            $admin->email = "user$i@admin.com";
            $admin->password = bcrypt('12345678');
            $admin->role_id = 3;
            $admin->save();
        }
        */
    }
}
