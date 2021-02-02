<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reading_lists', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->after('order');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reading_lists', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('author_id');
        });
    }
}
