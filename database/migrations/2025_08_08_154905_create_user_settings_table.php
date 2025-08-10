<?php

declare(strict_types=1);

use App\Enums\Appearance;
use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use App\Models\User;
use App\Models\UserSetting;
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
        Schema::create((new UserSetting)->getTable(), function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->unique()->constrained()->cascadeOnDelete();

            $table->string('milk_unit', 5)->default(MilkUnit::Millis->value);
            $table->string('weight_unit', 5)->default(WeightUnit::Pounds->value);
            $table->string('height_unit', 5)->default(HeightUnit::Inches->value);
            $table->string('appearance', 15)->default(Appearance::Mauve->value);
            $table->string('timezone')->default('America/New_York');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new UserSetting)->getTable());
    }
};
