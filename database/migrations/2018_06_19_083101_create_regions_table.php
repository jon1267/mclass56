<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('slug');
            $table->integer('parent_id')->nullable()
                ->references('id')->on('regions')->onDelete('CASCADE');
            $table->timestamps();
            $table->unique(['parent_id', 'slug']);
            $table->unique(['parent_id', 'name']);
            //Не знал что так можно...(стр 20-21) references с 1-го поля на 2-ое по этой-же таблице.
            //Последние 2 строки это требование чтоб в пределах одного (повторяющегося) parent_id
            //были уникальный slug и name (это требование чтоб в одном регионе не было одинак городов).
            //Индекс в стр 18 нужен для big data. Для 2-3 сотен записей - не особо.
            //onDelete('CASCADE')- при удалении области удаляются все ее вложенные города. Если не стоит
            //CASCADE и ничего не стоит (те опущена часть с onDelete() то действ умолчание ('RESTRICT')
            //и удалять родителя пока есть дети - нельзя.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
