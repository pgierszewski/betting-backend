import ApiService from "@/common/api.service";

import { SET_BALANCE, SET_BET_HISTORY } from "./mutations.type";
import { UPDATE_BALANCE, GET_BET_HISTORY } from "./actions.type";

const state = {
    balance: 'loading...',
    betHistory: {
        data: [],
        loading: false
    }
};

const getters = {
    getBalance(state) {
      return state.balance;
    },
    getBetHistory(state) {
      return  state.betHistory;
    }
};

const actions = {
    [UPDATE_BALANCE](context) {
        return new Promise(resolve => {
            ApiService.setHeader();
            ApiService.get("secured/balance")
            .then(({ data }) => {
                context.commit(SET_BALANCE, data.balance);
                resolve(data);
            })
        });
    },
    [GET_BET_HISTORY](context) {
        return new Promise(resolve => {
            context.commit(SET_BET_HISTORY, {loading: true, betHistory: []});
            ApiService.setHeader();
            ApiService.get("secured/bet")
            .then(({ data }) => {
                context.commit(SET_BET_HISTORY, {loading: false, betHistory: data});
                resolve(data);
            })
        })
    }
}

const mutations = {
    [SET_BALANCE](state, balance) {
      state.balance = balance;
    },
    [SET_BET_HISTORY](state, data) {
      state.betHistory = data;
    }
}

export default {
    state,
    actions,
    mutations,
    getters
};
