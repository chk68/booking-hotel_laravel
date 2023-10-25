<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('type', ['Стандарт', 'Люкс']); // Поле "Класс" с возможными значениями "Стандарт" и "Люкс"
            $table->text('description')->nullable(); // Новое поле "Описание"
            $table->text('amenities')->nullable(); // Новое поле "Удобства"
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['type', 'description', 'amenities']);
        });
    }

}
