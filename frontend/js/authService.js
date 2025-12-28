const AuthService = {
  register: function (payload) {
    return Api.request("POST", "/auth/register", payload);
  },
  login: function (payload) {
    return Api.request("POST", "/auth/login", payload);
  },
  me: function () {
    return Api.request("GET", "/auth/me");
  }
};

window.AuthService = AuthService;
