<template>
  <layout>
    <div class="alert" v-if="$page.flash.success">
      <p>
        {{ $page.flash.success }}
      </p>
      <p @click="hideAlert" class="cursor-pointer">X</p>
    </div>
    <article>
      <header>
        <h1>Lists</h1>
        <button title="add list" class="text-gray-700">
          <Zondicon icon="list-add"  class="w-8 fill-current" />
        </button>
      </header>
    </article>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout.vue';

export default {
  components: {
    Layout
  },
  methods: {
    hideAlert() {
      this.$page.flash.success = '';
    }
  }
}
</script>

<style>

</style>
