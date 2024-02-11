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
        Schema::create('tb_error_application', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('id_user')->default('0');
            $table->date('tanggal');
            $table->string('module')->default('');
            $table->string('controller')->default('');
            $table->string('function')->default('');
            $table->string('error_line')->default('');
            $table->string('error_message')->default('');
            $table->string('status')->default('');
            $table->string('parameter')->default('');
            $table->string('created_by')->default('');
            $table->string('updated_by')->default('');
            $table->string('deleted_by')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_error_application');
    }
};
