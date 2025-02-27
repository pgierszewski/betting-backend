import ApiService from "@/common/api.service";

import { SET_AVAILABLE_MATCHES, SET_LEADERBOARDS, SET_LOADING, SET_SELECTED_MATCHES, SET_LOADING_BET } from "./mutations.type";
import { GET_MATCHES, GET_LEADERBOARDS, ADD_MATCH, BET, UPDATE_BALANCE } from "./actions.type";

const state = {
    availableMatches: [],
    leaderboards: [],
    loading: false,
    selectedMatches: [],
    betLoading: false,
};

const getters = {
    getMatches(state) {
      return state.availableMatches;
    },
    getLeaderboards(state) {
      return state.leaderboards;
    },
    getLoading(state) {
      return state.loading;
    },
    getSelectedMatches(state) {
      return state.selectedMatches;
    },
    getBetLoading(state) {
      return state.betLoading;
    }
};

const actions = {
    [GET_MATCHES](context) {
        return new Promise(resolve => {
            context.commit(SET_LOADING, true)
            ApiService.get("match/available")
            .then(({ data }) => {
                context.commit(SET_AVAILABLE_MATCHES, data);
                context.commit(SET_LOADING, false);
                resolve(data);
            })
        });
    },
    [GET_LEADERBOARDS](context) {
        return new Promise(resolve => {
            context.commit(SET_LOADING, true)
            ApiService.get("leaderboards")
            .then(({ data }) => {
                context.commit(SET_LEADERBOARDS, data);
                context.commit(SET_LOADING, false)
                resolve(data);
            })
        });
    },
    [ADD_MATCH](context, data) {
        return new Promise(resolve => {
            let selectedMatches = context.state.selectedMatches;
            let found = selectedMatches.find((match) => {
                return match.match.id == data.match.id
            });

            selectedMatches = selectedMatches.filter((match) => {
                if (match.match.id !== data.match.id) {
                    return true;
                }

                return false;
            });

            if (!found || found.pick !== data.pick) {
                selectedMatches.push(data);
            }
            context.commit(SET_SELECTED_MATCHES, selectedMatches)
            resolve(data)
        });
    },
    [BET](context, data) {
        return new Promise(resolve => {
            context.commit(SET_LOADING_BET, true);
            ApiService.setHeader();
            ApiService.post("secured/bet", data)
            .then(({ data }) => {
                context.commit(SET_SELECTED_MATCHES, []);
                context.commit(SET_LOADING_BET, false);
                context.dispatch(UPDATE_BALANCE)
                resolve(data);
            })
        });
    }
}

const mutations = {
    [SET_AVAILABLE_MATCHES](state, availableMatches) {
      state.availableMatches = availableMatches;
    },
    [SET_LEADERBOARDS](state, leaderboards) {
      state.leaderboards = leaderboards
    },
    [SET_LOADING](state, loading) {
        state.loading = loading
    },
    [SET_SELECTED_MATCHES](state, matches) {
        state.selectedMatches = matches
    },
    [SET_LOADING_BET](state, loading) {
        state.betLoading = loading;
    }
}

export default {
    state,
    actions,
    mutations,
    getters
};
