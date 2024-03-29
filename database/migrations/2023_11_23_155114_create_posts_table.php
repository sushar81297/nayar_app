<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('page_id');
            $table->string('post_id');
            $table->longText('message');
            $table->integer('comments');
            $table->text('shared')->nullable();
            $table->text('status_type')->nullable();
            $table->text('Liked')->nullable();
            $table->text('Love')->nullable();
            $table->text('Haha')->nullable();
            $table->text('Wow')->nullable();
            $table->text('Sad')->nullable();
            $table->text('Angry')->nullable();
            $table->text('Care')->nullable();
            $table->text('image')->nullable();
            $table->json('images')->nullable();
            $table->dateTime('created_time');
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
        Schema::dropIfExists('posts');
    }
};
