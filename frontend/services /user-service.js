// $.ajax({
//  url: Constants.PROJECT_BASE_URL + "auth/login",
//  type: "POST",
//  data: JSON.stringify(entity),
//  contentType: "application/json",
//  dataType: "json",
//  success: function (result) {
//    localStorage.setItem("user_token", result.data.token);
//    window.location.replace("index.html");
//  },
//  error: function (XMLHttpRequest, textStatus, errorThrown) {
//    toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
//  },
// });


const UserService = {
  register: function (payload, onSuccess, onError) {
    $.ajax({
      url: API_BASE_URL + "/auth/register",
      type: "POST",
      data: JSON.stringify(payload),
      contentType: "application/json",
      success: onSuccess,
      error: onError
    });
  },

  login: function (payload, onSuccess, onError) {
    $.ajax({
      url: API_BASE_URL + "/auth/login",
      type: "POST",
      data: JSON.stringify(payload),
      contentType: "application/json",
      success: onSuccess,
      error: onError
    });
  }
};
