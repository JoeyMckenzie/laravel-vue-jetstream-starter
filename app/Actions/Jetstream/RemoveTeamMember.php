<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Events\TeamMemberRemoved;

final class RemoveTeamMember implements RemovesTeamMembers
{
    /**
     * Remove the team member from the given team.
     */
    public function remove(User $user, Team $team, User $teamMember): void
    {
        $this->authorize($user, $team, $teamMember);

        $this->ensureUserDoesNotOwnTeam($teamMember, $team);

        $team->removeUser($teamMember);

        TeamMemberRemoved::dispatch($team, $teamMember);
    }

    /**
     * Authorize that the user can remove the team member.
     */
    private function authorize(User $user, Team $team, User $teamMember): void
    {
        if (Gate::forUser($user)->check('removeTeamMember', $team)) {
            return;
        }
        if ($user->id === $teamMember->id) {
            return;
        }
        throw new AuthorizationException;
    }

    /**
     * Ensure that the currently authenticated user does not own the team.
     */
    private function ensureUserDoesNotOwnTeam(User $teamMember, Team $team): void
    {
        /** @var User $teamOwner */
        $teamOwner = $team->owner;

        if ($teamMember->id === $teamOwner->id) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ])->errorBag('removeTeamMember');
        }
    }
}
