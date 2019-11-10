<template lang="pug">
  div(class="home")
    ul(v-for="match in getMatches")
      | qwe
</template>


<script>
import { mapGetters } from "vuex";
import { GET_MATCHES } from "@/store/actions.type";

export default {
  name: 'home',
  mounted() {
        this.$store.dispatch(GET_MATCHES)
    },
  components: {
  },
  computed: {
    ...mapGetters(["getMatches"]),
  }
}
</script>
