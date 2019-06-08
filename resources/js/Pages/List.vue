<template>
  <layout>
    <div
      class="alert"
      v-if="$page.flash.success"
    >
      <p>
        {{ $page.flash.success }}
      </p>
      <p
        @click="hideAlert"
        class="cursor-pointer"
      >X</p>
    </div>
    <article>
      <header>
        <h1>{{ todoList.name }}</h1>
        <input
          v-if="addingNewItem"
          v-model="newItemDescription"
          @keydown.esc="leaveAddingMode"
          @keydown.enter="addItem"
          ref="newItemInput"
          class="border border-gray-400 rounded-full px-4"
        />
        <button
          v-else
          title="add list"
          class="text-gray-700"
          @click="enterAddingMode"
        >
          <Zondicon
            icon="add-solid"
            class="w-8 fill-current"
          />
        </button>
      </header>
      <section class="p-4">
        <div v-for="item in unarchivedItems" :key="item.hashid" class="flex items-center py-2 px-4 hover:bg-gray-400">
          <div class="w-8 flex-none">
            <input type="checkbox" v-model="item.completed_at" class="mt-2" @click="toggleItemCompletion(item)">
          </div>
          <h2 class="flex-grow" :class="{'text-gray-500': item.completed_at, 'line-through': item.completed_at}">
            <span v-if="isEditing(item)">
              <input
                type="text"
                ref="itemDescriptionInput"
                v-model="editing.description"
                @keydown.esc="cancelEditing"
                @keydown.enter="updateItem"
              >
            </span>
            <span
              @click.stop="edit(item)"
              class="cursor-text"
              v-else
            >
              {{ item.description }}
            </span>
          </h2>
          <div class="w-16 flex-none">
            <button
              v-if="item.completed_at"
              class="text-gray-500 cursor-pointer"
              title="Archive"
              @click="archiveItem(item)"
            >
              <Zondicon
                icon="box"
                class="w-8 fill-current"
              />
            </button>
            <button
              v-else
              class="text-gray-500 cursor-pointer"
              title="Delete"
              @click="removeItem(item)"
            >
              <Zondicon
                icon="trash"
                class="w-8 fill-current"
              />
            </button>
          </div>
        </div>
      </section>
    </article>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout.vue';

export default {
  components: { Layout },
  props: ['todoList'],
  data() {
    return {
      addingNewItem: false,
      newItemDescription: '',
      editing: {},
    }
  },
  computed: {
    unarchivedItems() {
      return this.todoList.items.filter(item => !item.archived_at)
    }
  },
  methods: {
    enterAddingMode() {
      this.addingNewItem = true;
      this.$nextTick(() => {
        this.$refs.newItemInput.focus()
      })
    },
    leaveAddingMode() {
      this.addingNewItem = false;
    },
    addItem() {
      this.$inertia.post(this.route('items.store', this.todoList.hashid), {
        'description': this.newItemDescription,
      })
      .then(() => {
        this.addingNewItem = false;
      })
    },
    edit(item) {
      this.editing = item;
      this.$nextTick(() => {
        this.$refs.itemDescriptionInput[0].focus()
      })
    },
    isEditing(item) {
      return this.editing.hashid === item.hashid;
    },
    cancelEditing() {
      this.editing = {};
    },
    updateItem() {
      if (!this.editing.description.length) {
        alert('You must provide an item description.')
        return;
      }
      this.$inertia.post(this.route('items.update', [this.todoList.hashid, this.editing.hashid]), {
        description: this.editing.description
      })
      .then(() => {
        this.cancelEditing()
      })
    },
    removeItem(item) {
      this.$inertia.delete(this.route('items.destroy', [this.todoList.hashid, item.hashid]))
    },
    archiveItem(item) {
      this.$inertia.post(this.route('items.archive', [this.todoList.hashid, item.hashid]))
    },
    toggleItemCompletion(item) {
      if (item.completed_at) {
        this.$inertia.delete(this.route('items.incomplete', [this.todoList.hashid, item.hashid]))
      } else {
        this.$inertia.post(this.route('items.complete', [this.todoList.hashid, item.hashid]))
      }
    }
  }
}
</script>

<style>

</style>
