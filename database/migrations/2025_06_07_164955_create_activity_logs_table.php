<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the activity
            $table->string('description'); // Description of the activity
            $table->string('user_id'); // ID of the user who performed the activity
            $table->string('ip_address'); // IP address of the user
            $table->string('user_agent'); // User agent of the user
            $table->string('status'); // Status of the activity (e.g., success, failure)
            $table->string('type'); // Type of activity (e.g., login, logout, update)
            $table->string('url'); // URL where the activity took place
            $table->string('method'); // HTTP method used (e.g., GET, POST)
            $table->text('payload')->nullable(); // Additional data related to the activity
            $table->string('response_code'); // HTTP response code (e.g., 200, 404)
            $table->text('response_body')->nullable(); // Response body of the activity
            $table->string('error_message')->nullable(); // Error message if the activity failed
            $table->string('error_code')->nullable(); // Error code if the activity failed
            $table->string('session_id')->nullable(); // Session ID if applicable
            $table->string('trace_id')->nullable(); // Trace ID for distributed tracing
            $table->string('correlation_id')->nullable(); // Correlation ID for tracking requests
            $table->string('environment')->default('production'); // Environment where the activity took place (e.g., production, staging)
            $table->string('application')->default('web'); // Application where the activity took place (e.g., web, mobile)
            $table->string('version')->nullable(); // Version of the application where the activity took place
            $table->timestamps();
            $table->softDeletes(); // Soft delete column for activity logs
            $table->index(['user_id', 'created_at']); // Index for user ID and created at for faster queries
            $table->index(['status', 'type']); // Index for status and type for faster queries
            $table->index(['ip_address', 'created_at']); // Index for IP address and created at for faster queries
            $table->index(['trace_id', 'created_at']); // Index for trace ID and created at for faster queries
            $table->index(['correlation_id', 'created_at']); // Index for correlation ID and created at for faster queries
            $table->index(['environment', 'created_at']); // Index for environment and created at for faster queries
            $table->index(['application', 'created_at']); // Index for application and created at for faster queries
            $table->index(['version', 'created_at']); // Index for version and created at for faster queries
            $table->unique(['user_id', 'name', 'created_at'], 'unique_activity_log'); // Unique constraint for user ID, activity name, and created at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
