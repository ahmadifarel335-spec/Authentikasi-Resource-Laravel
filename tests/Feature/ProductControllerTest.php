<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_product_management(): void
    {
        $response = $this->get(route('admin.produk.index'));

        $response->assertRedirectToRoute('login');
    }

    public function test_authenticated_user_can_view_the_product_list(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory();
        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => 12000,
            'stock' => 8,
        ]);

        $response = $this->actingAs($user)->get(route('admin.produk.index'));

        $response->assertOk()->assertSee('Teh Melati')->assertSee('Minuman');
    }

    public function test_authenticated_user_can_view_the_product_creation_form(): void
    {
        $user = User::factory()->create();
        $this->createCategory();

        $response = $this->actingAs($user)->get(route('admin.produk.create'));

        $response->assertOk()->assertSee('Tambah produk')->assertSee('Minuman');
    }

    public function test_authenticated_user_can_create_a_product(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory();

        $response = $this->actingAs($user)->post(route('admin.produk.store'), [
            'category_id' => $category->id,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => 12000,
            'stock' => 8,
        ]);

        $response->assertRedirectToRoute('admin.produk.index');
        $this->assertDatabaseHas('products', [
            'category_id' => $category->id,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => 12000,
            'stock' => 8,
        ]);
    }

    public function test_product_creation_rejects_invalid_category_and_negative_price(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.produk.store'), [
            'category_id' => 999,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => -1,
            'stock' => 8,
        ]);

        $response->assertInvalid(['category_id', 'price']);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_authenticated_user_can_update_a_product_without_changing_its_sku(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory();
        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => 12000,
            'stock' => 8,
        ]);

        $response = $this->actingAs($user)->put(route('admin.produk.update', $product), [
            'category_id' => $category->id,
            'name' => 'Teh Melati Premium',
            'sku' => 'TEH-001',
            'price' => 15000,
            'stock' => 12,
        ]);

        $response->assertRedirectToRoute('admin.produk.index');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Teh Melati Premium',
            'sku' => 'TEH-001',
            'price' => 15000,
            'stock' => 12,
        ]);
    }

    public function test_authenticated_user_can_delete_a_product(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory();
        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Teh Melati',
            'sku' => 'TEH-001',
            'price' => 12000,
            'stock' => 8,
        ]);

        $response = $this->actingAs($user)->delete(route('admin.produk.destroy', $product));

        $response->assertRedirectToRoute('admin.produk.index');
        $this->assertModelMissing($product);
    }

    private function createCategory(): Category
    {
        return Category::query()->create([
            'name' => 'Minuman',
            'slug' => 'minuman',
        ]);
    }
}
