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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('chat_id');
            $table->string('timestamp')->nullable();
            $table->string('readed_at')->nullable();
            $table->string('message_id')->unique();
            $table->string('type');
            $table->string('direction');
            $table->string('sended_by')->nullable();
            $table->json('body');
            $table->smallInteger('status')->default('20');
            $table->foreignId('response_to')->nullable()->constrained('messages');
            $table->string('reaction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
