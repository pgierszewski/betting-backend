<template lang="pug">
  div(class="home")
    h1
      | Leaderboards
    a-table(
        :columns="columns"
        :dataSource="getLeaderboards"
        :pagination="false"
        :rowKey="record => record.email"
        :loading="getLoading"
        class="leaderboards-table"
    )
      span(slot="positionTitle")
        a-icon(type="smile-o" width="")

</template>


<script>
import { mapGetters } from "vuex";
import { GET_LEADERBOARDS } from "@/store/actions.type";

const columns = [
    {
      dataIndex: 'position',
      key: 'position',
      slots: { title: 'positionTitle' },
      width: '5%'
    },
    {
      title: 'e-mail',
      dataIndex: 'email',
      key: 'email',
    },
    {
      title: 'Points',
      dataIndex: 'balance',
      key: 'balance'
    }
];

export default {
  data() {
      return {
          columns
      }
  },
  mounted() {
        this.$store.dispatch(GET_LEADERBOARDS)
    },
  components: {
  },
  computed: {
    ...mapGetters(["getLeaderboards", "getLoading"]),
  }
}
</script>
<style>
.leaderboards-table {
    width: 450px;
}
.home h1 {
    display: flex;
    justify-content: center;
}
.home {

}
</style>
