function loadNotifications(url, admin, user) {
  let timeout = 0;
  let previousContent = "";
  let isFirstLoad = true; // Flag to track the initial page load

  function loadRequests() {
    $.get(
      url,
      {
        isNotification: true,
        [admin]: user, // Use dynamic property name based on admin
      },
      function (data) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(data, "text/html");
        var aElements = doc.querySelectorAll("a.notification");
        var numberOfAElements = aElements.length;

        if (!isFirstLoad && +numberOfAElements > previousContent) {
          //   sendNotification(
          //     `New notification from ${
          //       doc.querySelector("span.sender").textContent
          //     }`,
          //     "tap to see the details",
          //     "images/notification.png",
          //     window.location.href
          //   );
        }

        $("#result").html(data);

        previousContent = numberOfAElements;
        isFirstLoad = false; // Set the flag to false after the first load

        setTimeout(loadRequests, 3000);
      }
    );
  }

  loadRequests();
}

function sendMail(to, message) {
  $.get("ajax/SendMail.php", {
    to: to,
    message: message,
  });
}

function Gndt(type, user) {
  if (type === "home") {
    loadNotifications("ajax/GetAdminReq.php", "admin", user);
  }

  // if (type === "reqAction") {
  //   loadNotifications("ajax/GetAdminReq.php", "admin", user);
  // }

  if (type === "excauter") {
    loadNotifications("ajax/GetRequests.php", "executer", user);
  }

  if (type === "wereHouse") {
    loadNotifications("ajax/GetWereHouseReq.php", "wereHouse", user);
  }

  if (type === "inspector") {
    loadNotifications("ajax/GetInspectorRequests.php", "inspector", user);
  }
}

// Get items and inspectors
function GetIaI() {
  $("#area").on("change", function (e) {
    $.get("ajax/GetItems.php", { areaId: $("#area").val() }, function (data) {
      $("#item").html(data);
    });
    $.get(
      "ajax/GetInspectors.php",
      { areaId: $("#area").val() },
      function (data) {
        $("#inspector").html(data);
      }
    );
  });
}
