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
        Schema::table('financial_affairs', function (Blueprint $table) {
            $table->string('item_name')->nullable()->change();
            $table->string('item_number')->nullable()->change();
            $table->string('attachment_number')->nullable()->change();
            $table->decimal('attachment_amount', 12, 2)->nullable()->change();
            $table->date('attachment_date')->nullable()->change();
        });
    }
    
    public function down(): void
    {
        Schema::table('financial_affairs', function (Blueprint $table) {
            $table->string('item_name')->nullable(false)->change();
            $table->string('item_number')->nullable(false)->change();
            $table->string('attachment_number')->nullable(false)->change();
            $table->decimal('attachment_amount', 12, 2)->nullable(false)->change();
            $table->date('attachment_date')->nullable(false)->change();
        });
    }
    
};
