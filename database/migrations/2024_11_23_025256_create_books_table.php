<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title');
            $table->string('author');
            $table->string('category'); // E.g., Fiction, Academic
            $table->boolean('is_physical'); // True for physical, false for e-books
            $table->string('location')->nullable(); // For physical books
            $table->boolean('access_code_required')->default(false); // For e-books
            $table->string('access_code')->nullable(); // Access code for e-books
            $table->boolean('available')->default(true); // Availability for borrowing
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
