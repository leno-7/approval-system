<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_requests', function (Blueprint $table) {
            $table->id();
            $table->string('project_number')->nullable();
            $table->date('request_date')->nullable();
            $table->string('owner_department')->nullable();
            $table->string('project_name');
            $table->decimal('estimated_value', 15, 2);
            $table->string('estimated_value_text')->nullable();
            $table->json('specifications_attachment')->nullable();
            $table->string('project_type');
            $table->integer('duration_day');
            $table->integer('duration_month');
            $table->integer('duration_year');
            $table->text('project_description');
            $table->text('project_scope');
            $table->json('project_objectives')->nullable();
            $table->json('suggested_vendors')->nullable();
            $table->text('notes')->nullable();
           
            $table->boolean('approved_by_owner')->nullable();


            $table->timestamp('approved_by_owner_at')->nullable();
            $table->text('owner_notes')->nullable();

            $table->boolean('approved_by_first_owner')->nullable();
            $table->timestamp('approved_by_first_owner_at')->nullable();
            $table->text('first_owner_notes')->nullable();

            $table->boolean('approved_by_second_owner')->nullable();
            $table->timestamp('approved_by_second_owner_at')->nullable();
            $table->text('second_owner_notes')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_requests');
         $table->dropColumn('estimated_value_text');
    }
};
