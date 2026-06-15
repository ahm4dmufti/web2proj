<?php

use App\Enums\TeamRole;
use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

test('team invitations can be created', function () {
    Notification::fake();

    $owner = User::factory()->create();
    $team = Team::factory()->create();

    $team->members()->attach($owner, ['role' => TeamRole::Owner->value]);

    $response = $this
        ->actingAs($owner)
        ->post(route('teams.invitations.store', $team), [
            'email' => 'invited@example.com',
            'role' => TeamRole::Member->value,
        ]);

    $response->assertRedirect(route('teams.edit', $team));

    $this->assertDatabaseHas('team_invitations', [
        'team_id' => $team->id,
        'email' => 'invited@example.com',
        'role' => TeamRole::Member->value,
    ]);
});

test('team invitations can be created by admins', function () {
    Notification::fake();

    $owner = User::factory()->create();
    $admin = User::factory()->create();
    $team = Team::factory()->create();

    $team->members()->attach($owner, ['role' => TeamRole::Owner->value]);
    $team->members()->attach($admin, ['role' => TeamRole::Admin->value]);

    $response = $this
        ->actingAs($admin)
        ->post(route('teams.invitations.store', $team), [
            'email' => 'invited@example.com',
            'role' => TeamRole::Member->value,
        ]);

    $response->assertRedirect(route('teams.edit', $team));
});

test('existing team members cannot be invited', function () {
    Notification::fake();

    $owner = User::factory()->create();
    $member = User::factory()->create(['email' => 'member@example.com']);
    $team = Team::factory()->create();

    $team->members()->attach($owner, ['role' => TeamRole::Owner->value]);
    $team->members()->attach($member, ['role' => TeamRole::Member->value]);

    $response = $this
        ->actingAs($owner)
        ->post(route('teams.invitations.store', $team), [
            'email' => 'member@example.com',
            'role' => TeamRole::Member->value,
        ]);

    $response->assertSessionHasErrors('email');
});

test('duplicate invitations cannot be created', function () {
    Notification::fake();

    $owner = User::factory()->create();
    $team = Team::factory()->create();
    $team->members()->attach($owner, ['role' => TeamRole::Owner->value]);

    TeamInvitation::factory()->create([
        'team_id' => $team->id,
        'email' => 'invited@example.com',
        'invited_by' => $owner->id,
    ]);

    $response = $this
        ->actingAs($owner)
        ->post(route('teams.invitations.store', $team), [
            'email' => 'invited@example.com',
            'role' => TeamRole::Member->value,
        ]);

    $response->assertSessionHasErrors('email');
});

test('team invitations cannot be created by members', function () {
    $owner = User::factory()->create();
    $member = User::factory()->create();
    $team = Team::factory()->create();

    $team->members()->attach($owner, ['role' => TeamRole::Owner->value]);
    $team->members()->attach($member, ['role' => TeamRole::Member->value]);

    $response = $this
        ->actingAs($member)
        ->post(route('teams.invitations.store', $team), [
            'email' => 'invited@example.com',
            'role' => TeamRole::Member->value,
        ]);

    $response->assertForbidden();
});

test('team invitations can be cancelled by owners', function () {
    $owner = User::factory()->create();
    $team = Team::factory()->create();

    $team->members()->attach($owner, ['role' => TeamRole::Owner->value]);

    $invitation = TeamInvitation::factory()->create([
        'team_id' => $team->id,
        'invited_by' => $owner->id,
    ]);

    $response = $this
        ->actingAs($owner)
        ->delete(route('teams.invitations.destroy', [$team, $invitation]));

    $response->assertRedirect(route('teams.edit', $team));

    $this->assertDatabaseMissing('team_invitations', [
        'id' => $invitation->id,
    ]);
});

