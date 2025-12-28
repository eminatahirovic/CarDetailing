const Api = {

  BASE_URL: "http://localhost/CarDetailing/backend",

  request: function (method, endpoint, data = null) {
    const options = {
      method: method,
      headers: {
        "Content-Type": "application/json"
      }
    };

    if (data) {
      options.body = JSON.stringify(data);
    }

    return fetch(this.BASE_URL + endpoint, options)
      .then(response => {
        if (!response.ok) {
          return response.text().then(text => {
            throw new Error(text || "Request failed");
          });
        }
        return response.json();
      });
  }
};

window.Api = Api;
