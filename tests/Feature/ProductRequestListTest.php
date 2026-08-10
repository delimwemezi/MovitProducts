<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductRequestListTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_product_list_page_is_accessible(): void
    {
        $response = $this->get('/product-lists/create');

        $response->assertOk();
    }
}
