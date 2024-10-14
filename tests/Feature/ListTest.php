<?php

use App\Models\User;
use App\Models\ListItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTest extends TestCase
{
    use RefreshDatabase;

    protected function createProductListsForUser($user, $count = 3)
    {
        return ListItem::factory()->count($count)->create(['user_id' => $user->id]);
    }
}

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

test('lists overview page shows "No product lists available" message and "Create a List" button when user has no lists', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertSee('No product lists available');
    $response->assertSee('Create a List');  // Ensure the button is visible
    $response->assertViewHas('productlists', function ($productlists) {
        return $productlists->isEmpty();
    });
});


test('lists overview page displays user\'s product lists when they exist', function () {
    $user = User::factory()->create();
    $lists = ListItem::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertViewHas('productlists');
    
    foreach ($lists as $list) {
        $response->assertSee($list->name);
    }
    $response->assertDontSee('No product lists available');
});

test('lists overview page displays empty list correctly', function () {
    $user = User::factory()->create();
    
    // Create a single list item (representing an empty list)
    ListItem::factory()->create([
        'user_id' => $user->id,
        'name' => 'Empty List'
    ]);

    $response = $this->actingAs($user)->get('/lists');

    $response->assertStatus(200);
    $response->assertSee('Empty List'); // The name of the list should appear
    $response->assertSee('0 items', false); // Assuming you're displaying the item count
    $response->assertDontSee('No product lists available'); // Since a list exists
});
