import ApiService from "@/common/api.service";
import JwtService from "@/common/jwt.service";
import {
  LOGIN,
  LOGOUT,
  CHECK_AUTH,
  REGISTER
} from "./actions.type";
import { SET_AUTH, PURGE_AUTH, SET_ERROR, SET_LOADING_LOGIN } from "./mutations.type";
import jwt_decode from 'jwt-decode';

const state = {
  errors: null,
  user: {},
  isAuthenticated: !!JwtService.getToken(),
  loadingLogin: false
};

const getters = {
  currentUser(state) {
    return state.user;
  },
  isAuthenticated(state) {
    return state.isAuthenticated;
  },
  getLoadingLogin(state) {
    return state.loadingLogin;
  }
};

const actions = {
  [LOGIN](context, credentials) {
    return new Promise(resolve => {
      context.commit(SET_LOADING_LOGIN, true);
      ApiService.post("auth/login", credentials)
        .then(({ data }) => {
          context.commit(SET_AUTH, data);
          context.commit(SET_LOADING_LOGIN, false);
          resolve(data);
        })
        .catch(({ response }) => {
          context.commit(SET_LOADING_LOGIN, false);
          context.commit(SET_ERROR, response.data.message);
        });
    });
  },
  [LOGOUT](context) {
    context.commit(PURGE_AUTH);
  },
  [CHECK_AUTH](context) {
    if (JwtService.getToken() && {}) {
      context.commit(SET_AUTH, { token: JwtService.getToken()})
    }
  },
  [REGISTER](context, credentials) {
    return new Promise((resolve) => {
      ApiService.post("auth/register", credentials)
        .then(({ data }) => {
          context.commit(SET_AUTH, data);
          resolve(data);
        })
        // .catch(({ response }) => {
        //   context.commit(SET_ERROR, response.data.errors);
        //   reject(response);
        // });
    });
  },
};

const mutations = {
  [SET_ERROR](state, error) {
    state.errors = error;
  },
  [SET_AUTH](state, data) {
    state.isAuthenticated = true;
    state.user = jwt_decode(data.token);
    state.errors = false;
    JwtService.saveToken(data.token);
  },
  [PURGE_AUTH](state) {
    state.isAuthenticated = false;
    state.user = {};
    state.errors = false;
    JwtService.destroyToken();
  },
  [SET_LOADING_LOGIN](state, loading) {
    console.log('qwe')
    state.loadingLogin = loading;
  }
};

export default {
  state,
  actions,
  mutations,
  getters
};
