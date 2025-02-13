<?php
// WooCommerce Product Import Script


require_once __DIR__ . '/../../../wp-load.php';

// Your code after including wp-load.php

function import_products_from_csv($csv_file) {
    if (!file_exists($csv_file)) {
        die("CSV file not found: " . $csv_file);
    }

    $handle = fopen($csv_file, 'r');
    $header = fgetcsv($handle); // Get headers
    
    while (($data = fgetcsv($handle)) !== false) {
        $product_data = array_combine($header, $data);
        
        // Create product object
        $product = new WC_Product_Simple();
        
        // Set product data
        $product->set_name($product_data['name']);
        $product->set_regular_price($product_data['regular_price']);
        $product->set_description($product_data['description']);
        $product->set_short_description($product_data['short_description']);
        $product->set_sku($product_data['sku']);
        $product->set_stock_quantity($product_data['stock_quantity']);
        $product->set_stock_status($product_data['stock_status']);
        $product->set_manage_stock(true);
        
        // Set product categories if provided
        if (!empty($product_data['categories'])) {
            $categories = explode(',', $product_data['categories']);
            $product->set_category_ids(array_map('intval', $categories));
        }
        
        // Save the product
        $product_id = $product->save();
        
        echo "Created product ID: " . $product_id . " - " . $product_data['name'] . "\n";
    }
    
    fclose($handle);
}

// Usage
$csv_file = 'products.csv';
import_products_from_csv($csv_file);