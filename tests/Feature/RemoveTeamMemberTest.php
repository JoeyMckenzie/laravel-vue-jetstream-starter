<?php

declare(strict_types=1);

use App\Models\User;

test('team members can be removed from teams', function (): void {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team members', function (): void {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

    $response->assertStatus(403);
});
