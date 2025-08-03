<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('project_request_completions', function (Blueprint $table) {
            $table->dropColumn([
                'approved_by_owner_director',
                'approved_by_owner_director_at',
                
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('project_request_completions', function (Blueprint $table) {
            $table->boolean('approved_by_owner_director')->nullable();
            $table->timestamp('approved_by_owner_director_at')->nullable();
           
        });
    }
};
