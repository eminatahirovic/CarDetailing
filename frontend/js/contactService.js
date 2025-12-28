const ContactService = {
  submit: function (payload) {
    return Api.request("POST", "/contact", payload);
  }
};

window.ContactService = ContactService;