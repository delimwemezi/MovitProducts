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
        $response->assertSee('Email address');
        $response->assertSee('Confirm and send list');
    }

    public function test_product_page_shows_cancel_option_for_selection_list(): void
    {
        $response = $this->get('/products');

        $response->assertOk();
        $response->assertSee('Cancel list');
    }
}
