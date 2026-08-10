<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListCreatePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product_list_page_renders_without_error(): void
    {
        $response = $this->get('/product-lists/create');

        $response->assertOk();
        $response->assertSee('Create your list');
    }
}
