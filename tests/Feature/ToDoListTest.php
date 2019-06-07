<?php

namespace Tests\Feature;

use App\User;
use App\ToDoList;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToDoListTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_can_be_created()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->followingRedirects()->post(route('lists.store'), [
            'name' => 'New List Name'
        ]);

        $response->assertComponentIs('Home');
        $response->assertPropCount('todoLists', 1);
        $this->assertDatabaseHas('to_do_lists', [
            'name' => 'New List Name',
            'user_id' => $user->id
        ]);
    }

    public function test_lists_cannot_be_created_without_names()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->post(route('lists.store'), [
            'name' => ''
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('to_do_lists', [
            'name' => 'New List Name',
            'user_id' => $user->id
        ]);
    }

    public function test_only_authorized_users_can_create_lists()
    {
        $user = factory(User::class)->create();

        $response = $this->followingRedirects()->post(route('lists.store'), [
            'name' => 'New List Name'
        ]);

        $response->assertComponentIs('Auth/Login');
        $this->assertDatabaseMissing('to_do_lists', [
            'name' => 'New List Name',
            'user_id' => $user->id
        ]);
    }

    public function test_lists_can_be_updated()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->followingRedirects()->post(route('lists.update', $list->hashid), [
            'name' => 'Updated List Name'
        ]);

        $response->assertComponentIs('Home');
        $response->assertPropCount('todoLists', 1);
        $this->assertDatabaseHas('to_do_lists', [
            'name' => 'Updated List Name',
            'user_id' => $user->id
        ]);
    }

    public function test_only_list_owners_can_update_their_lists()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $this->actingAs($userA);
        $list = factory(ToDoList::class)->create([
            'user_id' => $userB->id,
        ]);

        $response = $this->post(route('lists.update', $list->hashid), [
            'name' => 'Updated List Name'
        ]);

        $this->assertDatabaseMissing('to_do_lists', [
            'name' => 'Updated List Name',
            'user_id' => $userB->id
        ]);
    }

    public function test_lists_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->followingRedirects()->delete(route('lists.destroy', $list->hashid));

        $response->assertComponentIs('Home');
        $response->assertPropCount('todoLists', 0);
        $this->assertDatabaseMissing('to_do_lists', [
            'id' => $list->id,
        ]);
    }

    public function test_only_list_owners_can_delete_their_lists()
    {
        $userA = factory(User::class)->create();
        $userB = factory(User::class)->create();
        $this->actingAs($userA);
        $list = factory(ToDoList::class)->create([
            'user_id' => $userB->id,
        ]);

        $response = $this->delete(route('lists.destroy', $list->hashid));

        $this->assertDatabaseHas('to_do_lists', [
            'id' => $list->id
        ]);
    }

    // public function test_deleting_lists_also_removes_list_items()
    // {

    // }
}
