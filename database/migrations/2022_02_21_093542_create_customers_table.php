<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->string('tax_number')->nullable();
            $table->longText('address')->nullable();
            $table->integer('is_active')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });

        // Add a trigger to format the ID to 4 digits 
        DB::unprepared(' CREATE TRIGGER format_customer_id 
        BEFORE INSERT ON customers FOR EACH ROW BEGIN IF NEW.id < 1000 THEN SET NEW.id = LPAD(NEW.id, 4, "0"); 
        END IF; 
        END ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    
     public function down() { 
        // Drop the trigger 
        DB::unprepared('DROP TRIGGER IF EXISTS format_customer_id'); 
        Schema::dropIfExists('customers'); 
    }
}
