<template>
  <main>
    <header>
      <nav>
        <inertia-link href="/">
          {{ $page.auth.user.email }}
        </inertia-link>
      </nav>
      <aside>

        <a @click="logout" class="cursor-pointer">Logout</a>
      </aside>
    </header>

    <article class="container mx-auto pt-8">
      <slot />
    </article>
  </main>
</template>

<script>
export default {
  methods: {
    logout() {
       this.$inertia.post(this.route('logout'))
    }
  }
}
</script>
