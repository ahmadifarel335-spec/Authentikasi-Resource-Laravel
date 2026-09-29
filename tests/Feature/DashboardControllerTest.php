<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_the_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirectToRoute('login');
    }

    public function test_authenticated_user_sees_inventory_summary_and_latest_products(): void
    {
        $user = User::factory()->create();
        $category = Category::query()->create([
            'name' => 'Minuman',
            'slug' => 'minuman',
        ]);
        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => 12000,
            'stock' => 3,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertViewIs('dashboard')
            ->assertViewHasAll([
                'totalProducts' => 1,
                'totalCategories' => 1,
                'lowStockProducts' => 1,
                'outOfStockProducts' => 0,
            ])
            ->assertSee('Dashboard toko')
            ->assertSee($product->name);
    }
}
