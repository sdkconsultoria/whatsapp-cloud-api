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
        Schema::create('waba_phones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('waba_id');
            $table->string('phone_id');
            $table->string('name');
            $table->string('number');
            $table->string('number_clean');
            $table->string('quality_rating');
            $table->string('website');
            $table->string('email');
            $table->string('address');
            $table->text('about');
            $table->text('description');
            $table->string('vertical');
            $table->string('picture_profile');
            $table->string('currency');
            $table->string('number_status');
            $table->string('number_approval');
            $table->smallInteger('status')->default('20');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waba_phones');
    }
};
