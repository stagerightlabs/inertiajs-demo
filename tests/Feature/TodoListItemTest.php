<?php

namespace Tests\Feature;

use App\User;
use App\ToDoItem;
use App\ToDoList;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_items_can_be_added_to_lists()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->followingRedirects()->post(route('items.store', $list->hashid), [
            'description' => 'This is a list item'
        ]);

        $response->assertComponentIs('List');
        $this->assertDatabaseHas('to_do_items', [
            'list_id' => $list->id,
            'description' => 'This is a list item',
            'archived_at' => null,
            'completed_at' => null,
        ]);
    }

    public function test_items_can_be_updated()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()->post(route('items.update', [$list->hashid, $item->hashid]), [
            'description' => 'new description'
        ]);

        $response->assertComponentIs('List');
        $this->assertDatabaseHas('to_do_items', [
            'list_id' => $list->id,
            'description' => 'new description',
            'archived_at' => null,
            'completed_at' => null,
        ]);
    }

    public function test_items_can_be_removed_from_lists()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()
            ->delete(route('items.destroy', [$list->hashid, $item->hashid]));

        $response->assertComponentIs('List');
        $this->assertDatabaseMissing('to_do_items', [
            'id' => $item->id,
        ]);
    }

    public function test_items_can_be_completed()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()
            ->post(route('items.complete', [$list->hashid, $item->hashid]));


        $response->assertComponentIs('List');
        $item = $response->props('todoList')['items'][0];
        $this->assertNotNull($item['completed_at']);
    }

    public function test_items_can_have_completion_status_removed()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->state('completed')->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()
            ->delete(route('items.incomplete', [$list->hashid, $item->hashid]));

        $response->assertComponentIs('List');
        $item = $response->props('todoList')['items'][0];
        $this->assertNull($item['completed_at']);
    }

    public function test_items_can_be_archived()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()
            ->post(route('items.archive', [$list->hashid, $item->hashid]));


        $response->assertComponentIs('List');
        $item = $response->props('todoList')['items'][0];
        $this->assertNotNull($item['archived_at']);
    }

    public function test_items_can_have_archive_status_removed()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->state('archived')->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()
            ->delete(route('items.unarchive', [$list->hashid, $item->hashid]));

        $response->assertComponentIs('List');
        $item = $response->props('todoList')['items'][0];
        $this->assertNull($item['archived_at']);
    }

    public function test_deleting_lists_also_removes_list_items()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $list = factory(ToDoList::class)->create([
            'user_id' => $user->id
        ]);
        $item = factory(ToDoItem::class)->state('archived')->create([
            'list_id' => $list->id,
            'description' => 'original description'
        ]);

        $response = $this->followingRedirects()->delete(route('lists.destroy', $list->hashid));

        $response->assertComponentIs('Home');
        $this->assertDatabaseMissing('to_do_lists', [
            'id' => $list->id,
        ]);
        $this->assertDatabaseMissing('to_do_items', [
            'id' => $item->id,
        ]);
    }
}
