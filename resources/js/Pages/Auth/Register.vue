<template>
  <centered>
    <form @submit.prevent="submit">
      <header>
        <h2>Create a New Account</h2>
      </header>
      <section>
        <div class="mb-4">
          <label for="name">
            Name
          </label>
          <input
            id="name"
            type="text"
            v-model="form.name"
            :class="error('name') ? 'error' : ''"
          >
          <p v-if="error('name')" class="text-red-500 text-sm">{{ error('name') }}</p>
        </div>
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
          >
          <p v-if="error('password')" class="text-red-500 text-sm">{{ error('password') }}</p>
        </div>
        <div class="mb-6">
          <label for="password">
            Confirm Password
          </label>
          <input
            id="password"
            type="password"
            v-model="form.passwordConfirmation"
            :class="error('password_confirmation') ? 'error' : ''"
          >
          <p v-if="error('password_confirmation')" class="text-red-500 text-sm">{{ error('password_confirmation') }}</p>
        </div>
      </section>
      <footer>
        <div class="flex items-center justify-end">
          <button type="button" class="gray" :disabled="sending" @click="submit">
            Register
          </button>
        </div>
      </footer>
    </form>
  </centered>
</template>

<script>
import CenteredLayout from '@/Shared/CenteredLayout';
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
        name: '',
        email: '',
        password: '',
        passwordConfirmation: '',
      }
    }
  },
  methods: {
    submit() {
        this.sending = true
        this.$inertia.post(this.route('register.attempt'), {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.passwordConfirmation,
        })
        .then((response) => {
          this.sending = false
          console.log(response)
        })
    },
  }
}
</script>
