<?php

declare(strict_types=1);

use App\Models\User;

test('teams can be created', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $this->post('/teams', [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(2);
    expect($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
});
