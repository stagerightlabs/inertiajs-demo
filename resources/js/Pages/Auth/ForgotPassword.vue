<template>
  <centered>
    <form @submit.prevent="submit">
      <header>
        <h2 v-if="status">Success!</h2>
        <h2 v-else>Forgot Your Password?</h2>
      </header>
      <section>
        <div class="my-2" v-if="status">
          {{ status }}
        </div>
        <div class="mb-4" v-else>
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
      </section>
      <footer v-if="!status">
        <div class="flex items-center justify-end">
          <button type="button" class="gray" :disabled="sending" @click="submit">
            Send
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
    status: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      sending: false,
      form: {
        email: '',
      }
    }
  },
  methods: {
    submit() {
        this.sending = true
        this.$inertia.post(this.route('password.email'), {
          email: this.form.email,
        })
        .then((response) => {
          this.sending = false;
          this.form.email = '';
        })
    },
  }
}
</script>
