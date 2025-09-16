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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture_path')->nullable();
            $table->string('id_number')->nullable()->after('profile_picture_path');
            $table->string('phone_number')->nullable()->after('id_number');
            $table->string('first_name')->nullable()->after('phone_number');
            $table->string('surname')->nullable()->after('first_name');
            $table->date('date_of_birth')->nullable()->after('surname');
            $table->string('place_of_birth')->nullable()->after('date_of_birth');
            $table->string('city')->nullable()->after('place_of_birth');
            $table->text('address')->nullable()->after('city');
            $table->string('education')->nullable()->after('address');
            $table->string('institution')->nullable()->after('education');
            $table->string('major')->nullable()->after('institution');
            $table->text('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_picture',
                'id_number',
                'phone_number',
                'first_name',
                'surname',
                'date_of_birth',
                'place_of_birth',
                'city',
                'address',
                'education',
                'institution',
                'major',
            ]);
        });
    }
};
