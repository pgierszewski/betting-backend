<template lang="pug">
  div(class="match-home")
    h1
      | Matches
    div(
        v-for="matchBet in getMatches"
        v-if="!getLoading"
        :key="matchBet.id"
        class="match-wrapper"
      )
      div(
        class="team-a"
        :class="{ selected: isSelected(matchBet, 'teamIdA', getSelectedMatches) }"
        @click="addMatch({match: matchBet, pick: matchBet.teamIdA})"
      )
        b
          | {{ matchBet.oddsA }}
        p
          | {{ matchBet.teamNameA }}
      div(
        class="team-b"
        :class="{ selected: isSelected(matchBet, 'teamIdB', getSelectedMatches) }"
        @click="addMatch({match:matchBet, pick: matchBet.teamIdB})"
      )
        p
          | {{ matchBet.teamNameB }}
        b
          | {{ matchBet.oddsB }}
    a-spin(
      v-if="getLoading"
      size="large"
      class="spinner"
    )
</template>


<script>
import { mapGetters, mapActions } from "vuex";
import { GET_MATCHES } from "@/store/actions.type";

const isSelected = (match, teamKey, picks) => {
  let success = false;
  picks.forEach((pick) => {
    if (match.id != pick.match.id) {
      return;
    }
    if (match[teamKey] == pick.pick) {
      success = true;
    }
  })
  return success;
};

export default {
  name: 'home',
  mounted() {
        this.$store.dispatch(GET_MATCHES)
    },
  components: {
  },
  computed: {
    ...mapGetters(["getMatches", "getSelectedMatches", "getLoading"]),
  },
  methods: {
    ...mapActions(["addMatch"]),
    isSelected
  }
}
</script>
<style>
.match-home {
  width: 650px;
}
.match-home h1{
  justify-content: center;
  display: flex;
}
.match-wrapper {
  display: flex;
  justify-content: space-around;
  margin-bottom: 20px;
}
.match-wrapper p {
  margin: 0;
}
.team-a {
  display: flex;
  border: 1px solid #ebedf0;
  padding: 5px 5px 5px 5px;
  width: 300px;
  justify-content: space-between;
}
.team-a.selected {
 background-color: #1890ff;
 color: white;
}
.team-b {
  display: flex;
  border: 1px solid #ebedf0;
  padding: 5px 5px 5px 5px;
  width: 300px;
  justify-content: space-between;
}
.team-b.selected {
 background-color: #1890ff;
 color: white;
}
.spinner {
  display: flex !important;
  justify-content: center !important;
}
</style>

