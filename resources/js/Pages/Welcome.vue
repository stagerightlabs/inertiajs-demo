<template>
  <centered>
    <section>
      <h1 class="text-center py-4">Great Reads</h1>
      <p class="text-center py-2">Share and explore books with your friends.</p>
      <p class="flex justify-around py-8">
        <inertia-link :href="route('login')" class="button gray">Log In</inertia-link>
        <inertia-link :href="route('register')" class="button gray">Register</inertia-link>
      </p>
    </section>
  </centered>
</template>

<script>
import CenteredLayout from '@/Shared/CenteredLayout.vue';

export default {
  components: {
    centered: CenteredLayout
  }
}
</script>

<style>

</style>
