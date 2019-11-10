<template lang="pug">
a-layout(id="app")
  a-layout-header
    div(class="buttons")
      p
        router-link(to="/")
          | Betting
      p
        router-link(to="/leaderboards")
          | Leaderboards
      p(v-if="!isAuthenticated")
        router-link(to="/register")
          | Register
    LoginBox(v-if="!isAuthenticated" class="login-box")
    UserBox(v-if="isAuthenticated" class="user-box")
  a-layout
    a-layout-content
      router-view
    a-layout-sider(width="350")
     | Sider
  a-layout-footer
    | Backstreet Betting League
</template>

<script>
import { mapGetters } from "vuex";
import LoginBox from './components/LoginBox';
import UserBox from './components/UserBox';

export default {
  components: {
    LoginBox,
    UserBox
  },
  computed: {
    ...mapGetters(["isAuthenticated"]),
  }
}
</script>


<style lang="scss">
#app {
  height: 100%;
}
#app .user-box {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 400px;
}
#app .buttons {
  display: flex;
}
#app .buttons p {
  margin: 10px;
}
#app .ant-layout-content {
  background-color: #ffffff;
  border: 1px solid #ebedf0;
  display: flex;
  align-items: top;
  justify-content: center;
  padding-top: 30px;
}
#app .ant-layout-header {
  background-color: #ffffff;
  display: flex;
  padding-top: 20px;
  border: 1px solid #ebedf0;
  height: 100px;
  justify-content: space-between;
}
#app .ant-layout-footer {
  background-color: #ffffff;
  border: 1px solid #ebedf0;
}
#app .ant-layout-sider {
  background-color: #ffffff;
  border: 1px solid #ebedf0;
  width: 20%;
}
</style>
