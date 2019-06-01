export const validation = {
  methods: {
    error(key) {
      if (! key || key.length == 0) {
        return null;
      }

      if (this.$page.errors[key]) {
        return this.$page.errors[key][0];
      }

      return null;
    }
  }
}
