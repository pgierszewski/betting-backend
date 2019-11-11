import Vue from "vue";
import Vuex from "vuex";
import VuexPersist from 'vuex-persist';

import auth from "./auth.module";
import player from "./player.module";
import matches from './matches.module';

Vue.use(Vuex);
const vuexPersist = new VuexPersist({
  key: 'rockly',
  storage: window.localStorage
})

export default new Vuex.Store({
  modules: {
    auth,
    player,
    matches
  },
  plugins: [vuexPersist.plugin]
});
