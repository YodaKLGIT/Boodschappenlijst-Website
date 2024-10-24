<?php

use App\Models\User;
use App\Models\ListItem;
use App\Models\Product;

function createProductListsForUser($user, $count = 3, $withRandomDates = false, $withProducts = false)
{
    return ListItem::factory()->count($count)->create()->each(function ($list) use ($user, $withRandomDates, $withProducts) {
        if ($withRandomDates) {
            $list->created_at = now()->subDays(rand(1, 10));
            $list->updated_at = now()->subDays(rand(1, 10));
            $list->save();
        }

        $list->users()->attach($user);

        if ($withProducts) {
            $products = Product::factory()->count(rand(1, 5))->create();
            $productData = $products->mapWithKeys(function ($product) {
                return [$product->id => ['quantity' => rand(1, 10)]];
            })->toArray();
            $list->products()->attach($productData);
        }
    });
}

// ====================================
// Authentication and Access Tests
// ====================================


test('unauthenticated user cannot access lists overview screen', function () {
    $response = $this->get('/lists');

    $response->assertRedirect('/login');
});

test('authenticated user can render a lists overview screen', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertViewIs('lists.index');
});

// ====================================
// List Display Tests
// ====================================

test('lists overview page shows "No product lists available" message and "Create a List" button when user has no lists', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertSee('No product lists available');
    $response->assertSee('Create a new list');
    $response->assertViewHas('productlists', function ($productlists) {
        return $productlists->isEmpty();
    });
});

test('lists overview page displays empty list correctly', function () {
    $user = User::factory()->create();
    
    $list = ListItem::factory()->create(['name' => 'Empty List']);
    $list->users()->attach($user);

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertSee('Empty List');
    $response->assertSee('0', false);
    $response->assertDontSee('No product lists available');
});

test('lists overview page displays list with products correctly', function () {
    $user = User::factory()->create();
    
    $list = ListItem::factory()->create(['name' => 'List with Products']);
    $list->users()->attach($user);
    
    $products = Product::factory()->count(3)->create();
    $list->products()->attach($products);

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertSee('List with Products');
    $response->assertSee('3', false);
    $response->assertDontSee('No product lists available');
});

test('lists overview page displays user\'s product lists when they exist', function () {
    $user = User::factory()->create();
    $lists = ListItem::factory()->count(3)->create()->each(function ($list) use ($user) {
        $list->users()->attach($user);
    });

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertViewHas('productlists');
    
    foreach ($lists as $list) {
        $response->assertSee($list->name);
    }
    $response->assertDontSee('No product lists available');
});

// ====================================
// List Sorting and Filtering Tests
// ====================================

test('lists overview page sorts lists by title by default', function () {
    $user = User::factory()->create();
    createProductListsForUser($user, 3);

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $lists = $response->viewData('productlists');
    expect($lists->pluck('name')->sort()->values())->toEqual($lists->pluck('name'));
});

test('lists overview page sorts lists by last added when specified', function () {
    $user = User::factory()->create();
    createProductListsForUser($user, 3, true);

    $response = $this->actingAs($user)->get('/lists?sort=last_added');

    $response->assertStatus(200);
    $lists = $response->viewData('productlists');
    expect($lists->sortByDesc('created_at')->pluck('id'))->toEqual($lists->pluck('id'));
});

test('lists overview page sorts lists by last updated when specified', function () {
    $user = User::factory()->create();
    createProductListsForUser($user, 3, true);

    $response = $this->actingAs($user)->get('/lists?sort=last_updated');

    $response->assertStatus(200);
    $lists = $response->viewData('productlists');
    expect($lists->sortByDesc('updated_at')->pluck('id'))->toEqual($lists->pluck('id'));
});

test('lists overview page sorts lists by product count when specified', function () {
    $user = User::factory()->create();
    createProductListsForUser($user, 3, false, true);

    $response = $this->actingAs($user)->get('/lists?sort=product_count');

    $response->assertStatus(200);
    $sortedLists = $response->viewData('productlists');
    
    $productCounts = $sortedLists->pluck('products_count')->toArray();
    
    // Check if the array is sorted in descending order
    $sortedProductCounts = $productCounts;
    arsort($sortedProductCounts);
    expect($productCounts)->toEqual($sortedProductCounts);

    expect(count(array_unique($productCounts)))->toBeGreaterThan(1, 'There should be at least two different product counts');
});