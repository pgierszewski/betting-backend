import ApiService from "@/common/api.service";

import { SET_BALANCE } from "./mutations.type";
import { UPDATE_BALANCE } from "./actions.type";

const state = {
    balance: 'loading...'
};

const getters = {
    getBalance(state) {
      return state.balance;
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
    }
}

const mutations = {
    [SET_BALANCE](state, balance) {
      state.balance = balance;
    },
}

export default {
    state,
    actions,
    mutations,
    getters
};
