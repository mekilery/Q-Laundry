<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->string('tax_number')->nullable();
            $table->longText('address')->nullable();
            $table->integer('is_active')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE customers ADD id INT(4) UNSIGNED ZEROFILL PRIMARY KEY AUTO_INCREMENT');
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}