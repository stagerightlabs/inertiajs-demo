<template>
  <centered>
    <form @submit.prevent="submit">
      <header>
        <h2>Reset Your Password</h2>
      </header>
      <section>
        <div class="text-center p-4" v-if="error('token')">
          Please request a new <inertia-link :href="route('password.request')">password reset</inertia-link> link.
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
          <p v-if="error('email')" class="error-message">{{ error('email') }}</p>
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
            Save
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
  props: {
    email: {
      type: String,
      default: ''
    },
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      sending: false,
      form: {
        email: '',
        password: '',
        passwordConfirmation: '',
      }
    }
  },
  methods: {
    submit() {
        this.sending = true
        this.$inertia.post(this.route('password.update'), {
          token: this.token,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.passwordConfirmation,
        })
        .then((response) => {
          this.sending = false;
        })
    },
  },
  mounted() {
    this.form.email = this.email;
  }
}
</script>
