<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\DollarValue;
use App\Models\Product;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosModuleTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $customer;

    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);

        // Create customer user
        $this->customer = User::factory()->create([
            'role' => 'customer',
            'email' => 'customer@test.com',
            'rif' => 'J-12345678-9',
        ]);

        // Create dollar value
        DollarValue::create([
            'value' => 36.50,
            'date' => now(),
        ]);

        // Create tax
        $tax = Tax::create([
            'name' => 'IVA',
            'rate' => 16,
        ]);

        // Create product
        $this->product = Product::factory()->create([
            'name' => 'Test Product',
            'sku' => 'TEST-001',
            'price' => 100.00,
            'stock' => 10,
            'is_active' => true,
            'tax_id' => $tax->id,
        ]);
    }

    public function test_pos_index_page_is_accessible_by_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pos.index'));

        $response->assertStatus(200);
        $response->assertSee('Punto de Venta');
    }

    public function test_pos_index_page_is_not_accessible_by_customer(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.pos.index'));

        $response->assertStatus(403);
    }

    public function test_can_search_customers(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.customers.search'), [
                'query' => 'customer',
            ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['email' => 'customer@test.com']);
    }

    public function test_can_search_customers_by_rif(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.customers.search'), [
                'query' => 'J-12345678',
            ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['rif' => 'J-12345678-9']);
    }

    public function test_can_search_products(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.products.search'), [
                'query' => 'Test',
            ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Test Product']);
    }

    public function test_can_search_products_by_sku(): void
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.products.search'), [
                'query' => 'TEST-001',
            ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['sku' => 'TEST-001']);
    }

    public function test_can_create_customer_from_pos(): void
    {
        $customerData = [
            'name' => 'New Customer',
            'email' => 'newcustomer@test.com',
            'phone' => '04141234567',
            'rif' => 'V-98765432-1',
            'address' => 'Test Address 123',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.customers.store'), $customerData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'email' => 'newcustomer@test.com',
            'role' => 'customer',
            'rif' => 'V-98765432-1',
        ]);
    }

    public function test_cannot_create_customer_with_duplicate_email(): void
    {
        $customerData = [
            'name' => 'Duplicate Customer',
            'email' => 'customer@test.com', // Already exists
            'phone' => '04141234567',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.customers.store'), $customerData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_can_create_order_from_pos(): void
    {
        $orderData = [
            'customer_id' => $this->customer->id,
            'products' => [
                [
                    'id' => $this->product->id,
                    'quantity' => 2,
                ],
            ],
            'payment_method' => 'efectivo',
            'status' => 'pagada',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.orders.create'), $orderData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->customer->id,
            'payment_method' => 'efectivo',
            'status' => 'pagada',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // Verify stock was reduced
        $this->product->refresh();
        $this->assertEquals(8, $this->product->stock);
    }

    public function test_cannot_create_order_without_customer(): void
    {
        $orderData = [
            'products' => [
                [
                    'id' => $this->product->id,
                    'quantity' => 1,
                ],
            ],
            'payment_method' => 'efectivo',
            'status' => 'pagada',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.orders.create'), $orderData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['customer_id']);
    }

    public function test_cannot_create_order_without_products(): void
    {
        $orderData = [
            'customer_id' => $this->customer->id,
            'products' => [],
            'payment_method' => 'efectivo',
            'status' => 'pagada',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.orders.create'), $orderData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['products']);
    }

    public function test_cannot_create_order_with_insufficient_stock(): void
    {
        $orderData = [
            'customer_id' => $this->customer->id,
            'products' => [
                [
                    'id' => $this->product->id,
                    'quantity' => 20, // More than available stock (10)
                ],
            ],
            'payment_method' => 'efectivo',
            'status' => 'pagada',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.orders.create'), $orderData);

        $response->assertStatus(422);
        $response->assertJsonFragment(['success' => false]);
    }

    public function test_can_create_order_with_coupon(): void
    {
        $coupon = Coupon::create([
            'code' => 'TEST10',
            'type' => 'percentage',
            'value' => 10,
            'min_purchase' => 0,
            'max_uses' => 100,
            'used_count' => 0,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addMonth(),
            'is_active' => true,
        ]);

        $orderData = [
            'customer_id' => $this->customer->id,
            'products' => [
                [
                    'id' => $this->product->id,
                    'quantity' => 1,
                ],
            ],
            'payment_method' => 'efectivo',
            'status' => 'pagada',
            'coupon_code' => 'TEST10',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.orders.create'), $orderData);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->customer->id,
            'coupon_id' => $coupon->id,
        ]);

        // Verify coupon usage was incremented
        $coupon->refresh();
        $this->assertEquals(1, $coupon->used_count);
    }

    public function test_order_calculates_totals_correctly(): void
    {
        $orderData = [
            'customer_id' => $this->customer->id,
            'products' => [
                [
                    'id' => $this->product->id,
                    'quantity' => 2,
                ],
            ],
            'payment_method' => 'efectivo',
            'status' => 'pagada',
        ];

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.pos.orders.create'), $orderData);

        $response->assertStatus(200);

        // Product price: $100 x 2 = $200
        // With 16% tax included
        $expectedTotal = 200.00;
        $exchangeRate = 36.50;
        $expectedTotalBs = $expectedTotal * $exchangeRate;

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->customer->id,
            'total' => $expectedTotal,
        ]);
    }
}
