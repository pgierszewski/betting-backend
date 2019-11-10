import ApiService from "@/common/api.service";

import { SET_AVAILABLE_MATCHES, SET_LEADERBOARDS, SET_LOADING } from "./mutations.type";
import { GET_MATCHES, GET_LEADERBOARDS } from "./actions.type";

const state = {
    availableMatches: [],
    leaderboards: [],
    loading: false
};

const getters = {
    getMatches(state) {
      return state.availableMatches;
    },
    getLeaderboards(state) {
        return state.leaderboards
    },
    getLoading(state) {
        return state.loading
    }
};

const actions = {
    [GET_MATCHES](context) {
        return new Promise(resolve => {
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
    }
}

export default {
    state,
    actions,
    mutations,
    getters
};
