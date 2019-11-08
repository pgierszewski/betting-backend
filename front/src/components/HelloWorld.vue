<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <Button type="primary" loading>
      This is a test button
    </Button>
  </div>
</template>

<script>
import { Button } from 'ant-design-vue';

export default {
  components: {
    Button
  },
  name: 'HelloWorld',
  props: {
    msg: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
