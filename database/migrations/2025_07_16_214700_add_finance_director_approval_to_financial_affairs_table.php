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
            $table->boolean('approved_by_finance_director')->default(false);
            $table->date('approved_by_finance_director_at')->nullable();
            $table->text('finance_director_notes')->nullable();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('financial_affairs', function (Blueprint $table) {
            $table->dropColumn([
                'approved_by_finance_director',
                'approved_by_finance_director_at',
                'finance_director_notes',
            ]);
        });
    }
    
};
