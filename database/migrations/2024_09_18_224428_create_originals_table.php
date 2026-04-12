<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOriginalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('originals', function (Blueprint $table) {
            $table->id();
            $table->string('CFNUMPED')->unique();
            $table->boolean('read_only');
            $table->string('discount_2');
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('printed_at')->nullable();
            $table->unsignedInteger('print_count')->default(0);
            $table->dateTime('approved_at')->nullable();
            $table->text('comments');
            $table->json('content')->nullable();
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
        Schema::dropIfExists('originals');
    }
}
