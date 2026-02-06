<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartQuantityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_product_to_cart_via_ajax()
    {
        $product = Product::factory()->create();

        $response = $this->postJson(route('cart.ajax-add', $product->id));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'count' => 1,
                'quantity' => 1,
            ]);

        $this->assertEquals(1, session('cart')[$product->id]['quantity']);
    }

    public function test_can_update_product_quantity_via_ajax()
    {
        $product = Product::factory()->create();

        // Add first
        $this->postJson(route('cart.ajax-add', $product->id));

        // Update to 5
        $response = $this->postJson(route('cart.update', $product->id), [
            'quantity' => 5,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'count' => 1,
                'quantity' => 5,
            ]);

        $this->assertEquals(5, session('cart')[$product->id]['quantity']);
    }

    public function test_can_remove_product_when_quantity_is_zero_via_ajax()
    {
        $product = Product::factory()->create();

        // Add first
        $this->postJson(route('cart.ajax-add', $product->id));

        // Update to 0
        $response = $this->postJson(route('cart.update', $product->id), [
            'quantity' => 0,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'count' => 0,
                'quantity' => 0,
            ]);

        $this->assertArrayNotHasKey($product->id, session('cart', []));
    }
}
