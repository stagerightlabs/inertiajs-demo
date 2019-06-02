<template>
  <layout>
    <div class="alert" v-if="$page.flash.success">
      <p>
        {{ $page.flash.success }}
      </p>
      <p @click="hideAlert" class="cursor-pointer">X</p>
    </div>
    <h1>Home</h1>
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
