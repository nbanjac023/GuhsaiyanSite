<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });
        $data = [
            ['name' => 'Srbija'],
            ['name' => 'Albanija'],
            ['name' => 'Andora'],
            ['name' => 'Armenija'],
            ['name' => 'Austrija'],
            ['name' => 'Azerbejdžan'],
            ['name' => 'Belgija'],
            ['name' => 'Belorusija'],
            ['name' => 'Bosna i Hercegovina'],
            ['name' => 'Bugarska'],
            ['name' => 'Crna Gora'],
            ['name' => 'Danska'],
            ['name' => 'Estonija'],
            ['name' => 'Finska'],
            ['name' => 'Francuska'],
            ['name' => 'Gruzija'],
            ['name' => 'Grčka'],
            ['name' => 'Hrvatska'],
            ['name' => 'Irska'],
            ['name' => 'Island'],
            ['name' => 'Italija'],
            ['name' => 'Kazakhstan'],
            ['name' => 'Kipar'],
            ['name' => 'Kosovo'],
            ['name' => 'Latvija'],
            ['name' => 'Lihtenštajn'],
            ['name' => 'Litvanija'],
            ['name' => 'Luksemburg'],
            ['name' => 'Malta'],
            ['name' => 'Mađarska'],
            ['name' => 'Moldavija'],
            ['name' => 'Monako'],
            ['name' => 'Nizozemska'],
            ['name' => 'Njemačka'],
            ['name' => 'Norveška'],
            ['name' => 'Poljska'],
            ['name' => 'Portugal'],
            ['name' => 'Rumunija'],
            ['name' => 'Rusija'],
            ['name' => 'Sjeverna Makedonija'],
            ['name' => 'Slovačka'],
            ['name' => 'Slovenija'],
            ['name' => 'Turska'],
            ['name' => 'Ujedinjeno Kraljevstvo (UK)'],
            ['name' => 'Ukrajna'],
            ['name' => 'Češka Republika'],
            ['name' => 'Španija'],
            ['name' => 'Švajcarska'],
            ['name' => 'Švedska'],
        ];
        DB::table('countries')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
