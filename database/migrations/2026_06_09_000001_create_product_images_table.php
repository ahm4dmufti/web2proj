<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->longText('image_data');
            $table->string('image_mime');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Migrate existing single images to the new table
        DB::table('products')
            ->whereNotNull('image_data')
            ->get(['id', 'image_data', 'image_mime'])
            ->each(function ($product) {
                DB::table('product_images')->insert([
                    'product_id' => $product->id,
                    'image_data' => $product->image_data,
                    'image_mime' => $product->image_mime,
                    'sort_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

        // Drop old columns from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_data', 'image_mime']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('image_data')->nullable()->after('description');
            $table->string('image_mime')->nullable()->after('image_data');
        });

        // Restore first image back to products table
        DB::table('product_images')
            ->where('sort_order', 0)
            ->orWhereIn('id', function ($q) {
                $q->selectRaw('MIN(id)')->from('product_images')->groupBy('product_id');
            })
            ->get(['product_id', 'image_data', 'image_mime'])
            ->each(function ($img) {
                DB::table('products')->where('id', $img->product_id)->update([
                    'image_data' => $img->image_data,
                    'image_mime' => $img->image_mime,
                ]);
            });

        Schema::dropIfExists('product_images');
    }
};
