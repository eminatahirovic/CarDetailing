const HealthService = {
  check: function () {
    return Api.request("GET", "/health");
  }
};

window.HealthService = HealthService;