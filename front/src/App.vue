<template lang="pug">
a-layout(id="app")
  a-layout-header
    div(class="buttons")
      p
        | Betting
      p
        | Leaderboards
      p
        | Register
    LoginBox(class="login-box")
  a-layout
    a-layout-content
      router-view
    a-layout-sider
     | Sider
  a-layout-footer
    | Footer
</template>

<script>
import LoginBox from './components/LoginBox'

export default {
  components: {
    LoginBox
  }
}
</script>


<style lang="scss">
#app {
  height: 100%;
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
  align-items: center;
  justify-content: center;
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
}
</style>
