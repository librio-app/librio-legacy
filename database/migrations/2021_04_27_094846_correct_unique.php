<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CorrectUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = env('DB_PREFIX', 'librio_');
        Schema::table('series', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'series_code_unique');
            $table->unique(['code', 'deleted_at']);
        });

        Schema::table('categories', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'categories_code_unique');
            $table->unique(['code', 'deleted_at']);
        });

        Schema::table('authors', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'authors_code_unique');
            $table->unique(['code', 'deleted_at']);
        });

        Schema::table('books', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'books_code_unique');
            $table->unique(['code', 'deleted_at']);
        });

        Schema::table('publishers', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'publishers_code_unique');
            $table->unique(['code', 'deleted_at']);
        });

        Schema::table('types', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'types_code_unique');
            $table->unique(['code', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        $prefix = env('DB_PREFIX', 'librio_');
        Schema::table('series', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'series_code_deleted_at_unique');
            $table->unique(['code']);
        });

        Schema::table('categories', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'categories_code_deleted_at_unique');
            $table->unique(['code']);
        });

        Schema::table('authors', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'authors_code_deleted_at_unique');
            $table->unique(['code']);
        });

        Schema::table('books', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'books_code_deleted_at_unique');
            $table->unique(['code']);
        });

        Schema::table('publishers', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'publishers_code_deleted_at_unique');
            $table->unique(['code']);
        });

        Schema::table('types', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'types_code_deleted_at_unique');
            $table->unique(['code']);
        });

        Schema::table('series', function (Blueprint $table) use ($prefix) {
            $table->dropIndex( $prefix . 'series_code_deleted_at_unique');
            $table->unique(['code']);
        });
    }
}
