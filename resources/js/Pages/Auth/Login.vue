<template>
  <centered>
    <form @submit.prevent="submit">
      <header>
        <h2>Sign In</h2>
      </header>
      <section>
        <div class="mb-4">
          <label for="email">
            E-mail
          </label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            :class="error('email') ? 'error' : ''"
          >
          <p v-if="error('email')" class="text-red-500 text-sm">{{ error('email') }}</p>
        </div>
        <div class="mb-6">
          <label for="password">
            Password
          </label>
          <input
            id="password"
            type="password"
            v-model="form.password"
            :class="error('password') ? 'error' : ''"
            @keydown.enter="submit"
          >
          <p v-if="error('password')" class="text-red-500 text-sm">{{ error('password') }}</p>
        </div>
      </section>
      <footer>
        <div class="flex items-center justify-between">
          <inertia-link :href="route('password.request')" class="inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">Forgot Password?</inertia-link>
          <button type="button" class="gray" :disabled="sending" @click="submit">
            Go
          </button>
        </div>
      </footer>
    </form>
  </centered>
</template>

<script>
import CenteredLayout from '@/Shared/CenteredLayout.vue';
import { validation } from '@/Shared/Validation';

export default {
  mixins: [validation],
  components: {
    centered: CenteredLayout,
  },
  data() {
    return {
      sending: false,
      form: {
        email: '',
        password: '',
      }
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.route('login'), {
        email: this.form.email,
        password: this.form.password,
      })
      .then((response) => {
        this.sending = false
      })
    },
  }
}
</script>
