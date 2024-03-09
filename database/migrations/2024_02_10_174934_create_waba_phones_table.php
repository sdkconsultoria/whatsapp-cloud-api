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

            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->string('vertical')->nullable();
            $table->text('about')->nullable();
            $table->string('email')->nullable();
            $table->string('websites')->nullable();
            $table->string('profile_picture_url')->nullable();
            $table->string('messaging_product')->nullable();

            $table->string('name');
            $table->string('code_verification_status')->nullable();
            $table->string('display_phone_number');
            $table->string('phone_number_clean');
            $table->string('quality_rating');
            $table->string('phone_id');

            $table->string('pin')->nullable();
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
