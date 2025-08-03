<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('project_request_completions', function (Blueprint $table) {
            $table->boolean('approved_by_specialist')->nullable()->after('approved_by_pmo');
            $table->date('approved_by_specialist_at')->nullable()->after('approved_by_specialist');
            $table->text('specialist_notes')->nullable()->after('approved_by_specialist_at');

            $table->date('approved_by_pmo_at')->nullable()->after('specialist_notes');
            $table->text('pmo_director_notes')->nullable()->after('approved_by_pmo_at');
        });
    }

    public function down(): void
    {
        Schema::table('project_request_completions', function (Blueprint $table) {
            $table->dropColumn('approved_by_specialist');
            $table->dropColumn('approved_by_specialist_at');
            $table->dropColumn('specialist_notes');
            $table->dropColumn('approved_by_pmo_at');
            $table->dropColumn('pmo_director_notes');
        });
    }
};
