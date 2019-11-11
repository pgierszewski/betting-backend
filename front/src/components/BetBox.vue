<template lang="pug">
    div(class="bet-wrapper")
      h1
        | Bets
      div(v-for="match in getSelectedMatches" class="bet-box")
        p(class="")
          | {{ match.match.teamNameA }}
        p(class="")
          | vs
        p(class="")
          | {{ match.match.teamNameB }}
        b(class="team-pick")
          | Pick: {{ getPickedTeamName(match) }}
        b(class="")
          | Odds: {{ getPickedTeamOdds(match) }}
      b(v-if="getSelectedMatches.length > 0")
        | Odds: {{ combinedOdds }}
      a-input(
        :value="value"
        placeholder="Amount"
        :maxLength="25"
        @change="onChange"
        style="width: 100px; margin-top: 10px; margin-bottom: 10px;"
      )
      a-button(
          type="primary"
          class="bet-button"
          v-if="getSelectedMatches.length > 0 && isAuthenticated"
          :loading="getBetLoading"
          @click="bet({amount: value, betItems: mapMatches(getSelectedMatches)})"
        )
        | Bet
</template>
<script>
import { mapGetters, mapActions } from "vuex";

const getPickedTeamName = (match) => {
    if (match.pick == match.match.teamIdA) {
        return match.match.teamNameA;
    }
    return match.match.teamNameB;
}
const getPickedTeamOdds = (match) => {
    if (match.pick == match.match.teamIdA) {
        return match.match.oddsA;
    }
    return match.match.oddsB;
}
const mapMatches = (matches) => {
    let parsedMatches = [];
    matches.forEach((match) => {
        parsedMatches.push({
            matchId: match.match.id,
            teamId: match.pick
        });
    })

    return parsedMatches;
}
export default {
  methods: {
    getPickedTeamName,
    getPickedTeamOdds,
    mapMatches,
    onChange(e) {
        const { value } = e.target;
        const reg = /^-?(0|[1-9][0-9]*)?$/;
        if ((!isNaN(value) && reg.test(value)) || value === '' || value === '-') {
          this.value = value;
        }
    },
    ...mapActions(["bet"])
  },
  data() {
      return {
          value: 100
      }
  },
  computed: {
    ...mapGetters(["getSelectedMatches", "getBetLoading", "isAuthenticated"]),
    combinedOdds () {
      return this.getSelectedMatches.reduce((odds, match) => {
          return odds * getPickedTeamOdds(match);
      }, 1).toFixed(2);
    }
  },
}
</script>
<style lang="scss">
.bet-button {
    width: 100px;
}
.bet-wrapper {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-bottom: 40px;
}
.bet-wrapper .bet-box {
    justify-content: left;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 20px;
    border: 1px solid #ebedf0;

    p {
        height: 25px;
        padding: 0;
        margin: 0;
    }
}
</style>
