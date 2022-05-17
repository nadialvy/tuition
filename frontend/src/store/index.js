import { createStore } from 'vuex'

export default createStore({
  state: {
    isLogin: "",
    token: "",
    user_name: "",
    user_type: "",
  },
  mutations: {
    setToken: function(state, token){
      localStorage.setItem("Authorization", token)
      state.token = token
      state.isLogin = true
    },
    setUserName: function(state, data){
      state.user_name = data
      localStorage.setItem("user_name", data)
    },
    setUserType: function(state, data){
      state.user_type = data
      localStorage.setItem("user_type", data)
    },
    logout: function(state){
      localStorage.removeItem('Authorization')
      state.token = ""
      state.isLogin = false
      state.user = ""
    },
  },
})