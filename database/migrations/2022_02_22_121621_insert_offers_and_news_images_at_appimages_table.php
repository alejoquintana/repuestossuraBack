<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Appimage;

class InsertOffersAndNewsImagesAtAppimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        AppImage::create([
            'code'=>"offers_image",
            'name'=>"Imagen de Ofertas",
            'alt'=>"Imagen de Ofertas",
        ]);
        AppImage::create([
            'code'=>"news_image",
            'name'=>"Imagen de Novedades",
            'alt'=>"Imagen de Novedades",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
