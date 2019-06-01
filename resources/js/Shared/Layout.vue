<template>
  <main>
    <header>
      <nav>
        <inertia-link href="/">
          <h2 class="inline">
            {{ $page.app.name }}
          </h2>
        </inertia-link>
        <inertia-link href="/about">About</inertia-link>
        <inertia-link href="/contact">Contact</inertia-link>
      </nav>
      <aside>
        {{ $page.auth.user.email }}
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
