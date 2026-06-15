<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $pieces = [
            ['name' => '19th Century Ottoman Vase', 'category' => 'vase', 'description' => 'Hand-painted ceramic vase from the Ottoman Empire, circa 1850. Floral motifs in cobalt blue.', 'price' => 2450.00, 'is_available' => true],
            ['name' => 'Renaissance Oil Painting', 'category' => 'painting', 'description' => 'Italian school oil on canvas depicting a pastoral landscape, gold leaf frame.', 'price' => 8900.00, 'is_available' => true],
            ['name' => 'Victorian Emerald Brooch', 'category' => 'antique_piece', 'description' => 'Stunning 18k gold brooch set with natural emeralds and seed pearls, hallmarked London 1887.', 'price' => 3200.00, 'is_available' => false],
            ['name' => 'Hand-Woven Persian Carpet', 'category' => 'handcraft', 'description' => 'Silk and wool blend Isfahan carpet, intricate medallion pattern, 6x9 ft.', 'price' => 12500.00, 'is_available' => true],
            ['name' => 'Art Deco Table Lamp', 'category' => 'old_electronic', 'description' => 'Brass and frosted glass table lamp from 1920s Paris, fully rewired and functional.', 'price' => 1850.00, 'is_available' => true],
            ['name' => 'Ming Dynasty Porcelain Bowl', 'category' => 'vase', 'description' => 'Blue and white porcelain bowl, dragon motif, authenticated 15th century origin.', 'price' => 34000.00, 'is_available' => false],
            ['name' => 'Impressionist Watercolor', 'category' => 'painting', 'description' => 'French watercolor on paper, Seine river scene, signed and dated 1903.', 'price' => 4750.00, 'is_available' => true],
            ['name' => 'Georgian Silver Tea Set', 'category' => 'antique_piece', 'description' => 'Complete 5-piece sterling silver tea service, Sheffield 1812, exquisite engraving.', 'price' => 7600.00, 'is_available' => true],
            ['name' => 'Moroccan Mosaic Side Table', 'category' => 'handcraft', 'description' => 'Zellige tilework tabletop with wrought iron base, handcrafted in Fez.', 'price' => 980.00, 'is_available' => true],
            ['name' => 'Vintage Gramophone', 'category' => 'old_electronic', 'description' => 'HMV Model 102 portable gramophone, 1930s, original brass horn, working condition.', 'price' => 2100.00, 'is_available' => false],
        ];

        foreach ($pieces as $piece) {
            Product::create($piece);
        }
    }
}
