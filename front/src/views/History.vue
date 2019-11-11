<template lang="pug">
  div(class="home")
    h1
      | Bet History
    a-table(
        :columns="columns"
        :dataSource="getBetHistory.betHistory"
        :pagination="false"
        :rowKey="record => record.occuredOn"
        :loading="getBetHistory.loading"
        class="leaderboards-table"
    )

</template>


<script>
import { mapGetters } from "vuex";
import { GET_BET_HISTORY } from "@/store/actions.type";

const columns = [
    {
      dataIndex: 'occuredOn',
      key: 'occuredOn',
      title: 'Date'
    },
    {
      dataIndex: 'winnings',
      key: 'winnings',
      title: 'Winnings'
    },
    {
      dataIndex: 'resolvedOn',
      key: 'resolvedOn',
      title: 'Resolve date'
    },
    {
        dataIndex: 'items',
        key: 'items',
        title: 'Bet'
    }
];

export default {
  data() {
      return {
          columns
      }
  },
  mounted() {
        this.$store.dispatch(GET_BET_HISTORY)
    },
  components: {
  },
  computed: {
    ...mapGetters(["getBetHistory"]),
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
