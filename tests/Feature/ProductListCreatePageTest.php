<?php

namespace Tests\Feature;

use App\Models\BusinessProfile;
use App\Models\ProductRequestItem;
use App\Models\ProductRequestList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
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

    public function test_admin_approval_sends_whatsapp_message_to_customer_and_business_manager(): void
    {
        Http::fake();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);
        $business = BusinessProfile::create([
            'email' => 'manager@movitproducts.com',
            'location' => 'Dar es Salaam',
            'phone' => '+255700000001',
            'whatsapp_number' => '+255700000001',
        ]);

        $list = ProductRequestList::create([
            'user_id' => $admin->id,
            'customer_name' => 'customer@example.com',
            'phone' => '+255700000002',
            'whatsapp_number' => '+255700000002',
            'location' => 'Arusha',
            'notes' => 'Need this urgently',
            'total_amount' => 250000,
            'status' => 'reviewed',
        ]);

        ProductRequestItem::create([
            'product_request_list_id' => $list->id,
            'product_id' => null,
            'product_name' => 'Rice Bags',
            'cartons' => 2,
            'pieces' => 0,
            'unit_price' => 100000,
            'total_price' => 200000,
        ]);

        $this->actingAs($admin, 'web');

        $response = app(\App\Http\Controllers\AdminController::class)->replyToProductList(
            new \Illuminate\Http\Request([
                'admin_reply' => 'Approved. Please arrange delivery.',
            ]),
            $list->id
        );

        $this->assertNotNull($response);

        Http::assertSentCount(2);
        Http::assertSent(function ($request) use ($list) {
            $decodedUrl = urldecode($request->url());
            return str_contains($decodedUrl, 'wa.me/255700000002')
                && str_contains($decodedUrl, 'Approved. Please arrange delivery.');
        });
        Http::assertSent(function ($request) use ($business) {
            $decodedUrl = urldecode($request->url());
            return str_contains($decodedUrl, 'wa.me/255700000001');
        });
    }
}
