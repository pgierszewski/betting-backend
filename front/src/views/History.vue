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
        class="history-table"
    )
      div(slot="items" slot-scope="record")
        div(
          v-for="item in record"
          class="bet-item-history"
        )
          div(class="bet-content")
            | Match:
            | {{ item.teamA }}&nbsp;vs&nbsp;{{ item.teamB }}
            b(
              :class="{success: item.successful == true, lost: item.successful == false}"
            )
              div(class="icon-wrapper")
                a-icon(type="check" v-if="item.successful == true")
                a-icon(type="question" v-if="item.successful == null")
                a-icon(type="close" v-if="item.successful == false")
              | {{ item.odds }} &nbsp; {{ item.type }}

</template>


<script>
import { mapGetters } from "vuex";
import { GET_BET_HISTORY } from "@/store/actions.type";

const columns = [
    {
      dataIndex: 'occuredOn',
      key: 'occuredOn',
      title: 'Date',
      width: '15%'
    },
    {
      dataIndex: 'winnings',
      key: 'winnings',
      title: 'Winnings',
      width: '15%'
    },
    {
      dataIndex: 'resolvedOn',
      key: 'resolvedOn',
      title: 'Resolve date',
      width: '15%'
    },
    {
        dataIndex: 'items',
        key: 'items',
        title: 'Bet',
        scopedSlots: { customRender: 'items' },
        width: '55%'
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
<style <style lang="scss">
.bet-item-history {
  display: flex;

  .bet-content {
    display: flex;
    flex-direction: column;

    b {
      display: flex;
      flex-direction: row;
    }
    .success {
      color: green;
    }
    .lost {
      color: red; 
    }
  }
}
.history-table {
    width: 850px;
}
.home h1 {
    display: flex;
    justify-content: center;
}
</style>
