<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_request_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_request_id')->constrained()->onDelete('cascade');
            $table->text('project_scope')->nullable();
            $table->text('project_objectives')->nullable();
            $table->string('project_status')->nullable();
            $table->string('related_projects')->nullable();
            $table->string('request_type')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('pmo_officer')->nullable();
            $table->text('pmo_notes')->nullable();
            $table->boolean('approved_by_pmo')->nullable();
            $table->text('pmo_director_notes')->nullable();

            $table->boolean('approved_by_specialist')->nullable();
            $table->timestamp('approved_by_specialist_at')->nullable();
            $table->text('specialist_notes')->nullable();
            $table->timestamp('approved_by_pmo_at')->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_request_completions');
        
       
  
    }
};
