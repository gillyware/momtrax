<?php

declare(strict_types=1);

use App\Models\Child;
use App\Models\Feeding;
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
        Schema::create((new Feeding)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Child::class)->constrained()->cascadeOnDelete();
            $table->tinyInteger('feeding_type');
            $table->float('total_amount');
            $table->string('unit', 5);
            $table->integer('duration_in_minutes');
            $table->string('notes')->nullable();
            $table->timestamp('start_date_time');
            $table->timestamp('end_date_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new Feeding)->getTable());
    }
};
