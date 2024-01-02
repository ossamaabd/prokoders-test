<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('text')->nullable();
            $table->boolean('show_deny_button')->default(0);
            $table->boolean('show_cancel_button')->default(0);
            $table->boolean('animated')->default(0);
            $table->enum('icon',['success','warning','error','info','question']);
            $table->enum('position',['center','top','top-end','top-start','center-end','bottom','bottom-end']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('popups');
    }
}
