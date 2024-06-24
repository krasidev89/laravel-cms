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
        Schema::create('google_analytics_overviews', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('device_category', 64)->nullable();
            $table->string('operating_system', 64)->nullable();
            $table->string('browser', 64)->nullable();
            $table->string('continent', 32)->nullable();
            $table->string('country', 32)->nullable();
            $table->string('city', 32)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'device_category', 'operating_system', 'browser', 'continent', 'country', 'city'], 'google_analytics_overview_unique');
        });

        Schema::create('google_analytics_urls', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('path', 128)->nullable();
            $table->string('title', 64)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'path', 'title']);
        });

        Schema::create('google_analytics_locations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('continent', 32)->nullable();
            $table->string('country', 32)->nullable();
            $table->string('city', 32)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'continent', 'country', 'city']);
        });

        Schema::create('google_analytics_languages', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name', 32)->nullable();
            $table->string('code', 32)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'name', 'code']);
        });

        Schema::create('google_analytics_browsers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name', 64)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'name']);
        });

        Schema::create('google_analytics_operating_systems', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name', 64)->nullable();
            $table->string('version', 64)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'name', 'version']);
        });

        Schema::create('google_analytics_device_categories', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name', 64)->nullable();
            $table->unsignedInteger('visitors')->default(0);
            $table->unsignedInteger('pageviews')->default(0);
            $table->timestamps();
            $table->unique(['date', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_analytics_device_categories');
        Schema::dropIfExists('google_analytics_operating_systems');
        Schema::dropIfExists('google_analytics_browsers');
        Schema::dropIfExists('google_analytics_languages');
        Schema::dropIfExists('google_analytics_locations');
        Schema::dropIfExists('google_analytics_urls');
        Schema::dropIfExists('google_analytics_overviews');
    }
};
