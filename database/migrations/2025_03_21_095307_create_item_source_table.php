<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ITEM_SOURCE', function (Blueprint $table) {
			$table->bigIncrements('IDNo'); // Primary Key (bigint, auto-increment)
			$table->string('DESCRIPTION', 100); // VARCHAR(100)
			$table->unsignedBigInteger('ENCODED_BY'); // INT (User who encoded)
			$table->dateTime('ENCODED_DT')->default(now()); // DATETIME (Default current time)
			$table->unsignedBigInteger('EDITED_BY')->nullable(); // INT (User who edited)
			$table->dateTime('EDITED_DT')->nullable(); // DATETIME (Editable timestamp)
			$table->boolean('ACTIVE')->default(true); // BOOLEAN (Status of the record)
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_source');
    }
};
