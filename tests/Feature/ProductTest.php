<?php

use App\Models\User;

test('can render a product overview screen', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->assertAuthenticated();

    $response = $this->get('/products');

    $response->assertStatus(200);
});
