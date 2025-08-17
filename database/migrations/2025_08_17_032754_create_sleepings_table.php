<?php

declare(strict_types=1);

use App\Models\Child;
use App\Models\Sleeping;
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
        Schema::create((new Sleeping)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Child::class)->constrained()->cascadeOnDelete();
            $table->timestamp('start_date_time');
            $table->timestamp('end_date_time')->nullable();
            $table->string('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Sleeping)->getTable());
    }
};
