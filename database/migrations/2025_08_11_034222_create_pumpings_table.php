<?php

declare(strict_types=1);

use App\Models\Pumping;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create((new Pumping)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->float('left_breast_amount')->nullable();
            $table->float('right_breast_amount')->nullable();
            $table->float('total_amount')->nullable();
            $table->string('unit', 5);
            $table->integer('duration_in_minutes');
            $table->string('notes')->nullable();
            $table->timestamp('start_date_time');
            $table->timestamp('end_date_time');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists((new Pumping)->getTable());
    }
};
