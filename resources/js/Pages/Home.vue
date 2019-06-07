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
        <h1>Lists</h1>
        <button
          title="add list"
          class="text-gray-700"
          @click="newList"
        >
          <Zondicon
            icon="list-add"
            class="w-8 fill-current"
          />
        </button>
      </header>
      <section class="p-4">
        <div
          v-for="list in todoLists"
          :key="list.hashid"
          class="hover:bg-gray-400 p-4 flex justify-between cursor-pointer"
          @click="selectList(list)"
        >
          <h2>
            <span v-if="isEditing(list)">
              <input
                type="text"
                ref="listNameInput"
                v-model="editing.name"
                @keydown.esc="cancelEditing"
                @keydown.enter="updateList"
              >
            </span>
            <span
              @click.stop="edit(list)"
              class="cursor-pointer"
              v-else
            >{{ list.name }}</span>
          </h2>
          <button
            class="button text-gray-600"
            v-if="isEditing(list)"
            @click.stop="destroy(list)"
          >
            <Zondicon
              icon="trash"
              class="w-8 fill-current"
            />
          </button>
          <button
            class="button gray"
            @click="selectList(list)"
            v-else
          >View</button>
        </div>
      </section>
    </article>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout.vue';
import { validation } from '@/Shared/Validation';

export default {
  mixins: [validation],
  components: {
    Layout
  },
  props: {
    todoLists: Array,
  },
  data () {
    return {
      editing: {
        name: ''
      },
    }
  },
  methods: {
    hideAlert () {
      this.$page.flash.success = '';
    },
    newList () {
      this.$inertia.post(this.route('lists.store', this.editing.hashid), {
        name: 'New List'
      })
    },
    edit (list) {
      this.editing = list;
      this.$nextTick(() => {
        this.$refs.listNameInput[0].focus()
      })
    },
    isEditing (list) {
      return list.hashid === this.editing.hashid;
    },
    cancelEditing () {
      this.editing = {
        name: '',
      }
    },
    selectList (list) {
      if (this.isEditing(list)) {
        return;
      }
      alert('click')
    },
    updateList () {
      if (!this.editing.name.length) {
        alert('Your list must have a name.');
      }

      this.$inertia.post(this.route('lists.update', this.editing.hashid), {
        name: this.editing.name
      })
      .then(() => {
        this.cancelEditing();
      })
    },
    destroy (list) {
      this.$inertia.delete(this.route('lists.destroy', list.hashid))
    }
  }
}
</script>

<style>
</style>
