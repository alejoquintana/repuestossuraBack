<?php

use Illuminate\Database\Seeder;
use App\Survey;
use App\Role;

class SurveysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opts = ['Facebook', 'Google', 'Local en Moreno', 'Me lo recomendo un/a amigo/a', 'Otro'];        for ($i=0; $i < 50; $i++) { 
            $survey = new Survey();
            $survey->option = $opts[random_int(0,4)];
            $survey->comment = $survey->option.'-'.$survey->option.'-'.$survey->option;
            $survey->created_at = '20'.random_int(18,22).'-'.random_int(1,12).'-'.random_int(1,28).' 09:27:21';
            $survey->save();
        }
    }
}
