<template lang="pug">
    div
        RegisterBox(class="reg-box")
</template>

<script>
import RegisterBox from '../components/RegisterBox.vue'
export default {
    components: {
        RegisterBox
    }
}
</script>
<style>
.reg-box {
    width: 500px;
}
</style>
