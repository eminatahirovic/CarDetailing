const BookingService = {
  getByUserId: function (userId) {
    return Api.request("GET", `/bookings/user/${encodeURIComponent(userId)}`);
  },
  create: function (payload) {
    return Api.request("POST", "/bookings", payload);
  }
};

window.BookingService = BookingService;