<template lang="pug">
  div
    div(class="some-box")
        div(class="some-box-paragraph")
          | <b>Username:&nbsp;&nbsp;</b> {{ currentUser.username }}
        div(class="some-box-paragraph")
          | <b>Balance:&nbsp;&nbsp;</b> {{getBalance}}
    a-button(type="primary" @click="logout")
        | logout
</template>
<script>
import { mapGetters } from "vuex";
import { LOGOUT, UPDATE_BALANCE } from "@/store/actions.type";

export default {
    mounted() {
        this.$store.dispatch(UPDATE_BALANCE)
    },
    computed: {
    ...mapGetters(["getBalance", "currentUser"]),
   },
    methods: {
        logout() {
            this.$store.dispatch(LOGOUT);
        }
    }
}
</script>
<style>
.some-box {
    display: flex;
    flex-direction: column;
    height: 100px;
}
.some-box .some-box-paragraph {
    display: flex;
    height: 30px;
}
</style>
