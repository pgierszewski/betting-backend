import Vue from "vue";
import Vuex from "vuex";

import auth from "./auth.module";
import player from "./player.module";
import matches from './matches.module';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    auth,
    player,
    matches
  }
});
