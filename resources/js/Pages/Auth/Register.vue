<template>
  <billboard-layout>
    <h1 class="text-center">Register</h1>
      <form>
        <div class="mb-4">
          <label for="name">
            Name
          </label>
          <input id="username" type="text" placeholder="Name">
        </div>
        <div class="mb-4">
          <label for="name">
            E-mail
          </label>
          <input id="username" type="email" placeholder="E-Mail">
        </div>
        <div class="mb-6">
          <label for="password">
            Password
          </label>
          <input id="password" type="password" placeholder="******************">
          <!-- <p class="text-red-500 text-xs italic">Please choose a password.</p> -->
        </div>
        <div class="flex items-center justify-between">
          <button type="button">
            Sign In
          </button>
          <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
            Forgot Password?
          </a>
        </div>
      </form>
  </billboard-layout>
</template>

<script>
import BillboardLayout from '@/Shared/BillboardLayout'

export default {
  components: {
    BillboardLayout,
  },
}
</script>
