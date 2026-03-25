<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cart_persists_in_session()
    {
        $product = Product::factory()->create(['price' => 10]);

        $this->post(route('cart.add', $product->id));

        $this->assertArrayHasKey($product->id, session('cart'));
        $this->assertEquals(1, session('cart')[$product->id]['quantity']);
    }

    public function test_authenticated_user_cart_persists_in_database()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $product = Product::factory()->create(['price' => 10]);

        $this->actingAs($user)->post(route('cart.add', $product->id));

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $this->assertEmpty(session('cart', []));
    }

    public function test_guest_cart_merges_into_database_upon_login()
    {
        $user = User::factory()->create(['role' => 'customer', 'password' => bcrypt('password')]);
        $product = Product::factory()->create(['price' => 10]);

        // Add to cart as guest
        $this->post(route('cart.add', $product->id));
        $this->assertArrayHasKey($product->id, session('cart'));

        // Logic login
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        // Verify merge
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $this->assertArrayNotHasKey($product->id, session('cart', []));
    }

    public function test_checkout_works_with_database_cart()
    {
        $user = User::factory()->create(['role' => 'customer']);
        $product = Product::factory()->create(['price' => 10]);

        // Mock items in DB for user
        $this->actingAs($user)->post(route('cart.add', $product->id));

        // Attempt access checkout
        $response = $this->actingAs($user)->get(route('checkout.index'));

        $response->assertStatus(200);
        $response->assertSee('Resumen del Pedido');
        $response->assertSee(number_format($product->price, 2));
        $response->assertDontSeeText('Tu carrito está vacío.');
    }
}
