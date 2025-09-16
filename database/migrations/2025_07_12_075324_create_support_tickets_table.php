<?php

use App\Enums\TicketStatus;
use App\Enums\TicketSubject;
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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('full_name');
            $table->string('email');
            $table->enum('subject', TicketSubject::values());
            $table->text('description');
            $table->enum('status', TicketStatus::values())->default(TicketStatus::OPEN);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
