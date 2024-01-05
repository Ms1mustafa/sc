const itemDescription = document.getElementById("ItemDescription");
const itemDescriptionBody = document.getElementById("ItemDescriptionBody");
document.addEventListener("DOMContentLoaded", function () {
  let selectedOptions = [];

  itemDescription?.addEventListener("change", function () {
    const selectedValue = itemDescription.value;

    if (!selectedOptions.includes(selectedValue)) {
      selectedOptions.push(selectedValue);

      let html = `
              <tr class="itemTr">
                  <td class='pipe'><input class='pipe1 cantEdit' name="itemName[]" value="${selectedValue}" readonly></td>
                  <td><input class='pipe2' type="number" min="1" name="itemQty[]"></td>
                 
                  <td> <a class="deleteTr" ><i class="fa-sharp fa-solid fa-xmark"></i></a>  </td>
              </tr>
          `;

      itemDescriptionBody?.insertAdjacentHTML("afterbegin", html);
    }
    const deleteTr = document.querySelectorAll(".deleteTr");
    deleteTr?.forEach((btn) => {
      btn.addEventListener("click", () => {
        const deletedValue = btn.closest("tr").querySelector(".pipe1").value;
        const deletedIndex = selectedOptions.indexOf(deletedValue);
        if (deletedIndex !== -1) {
          selectedOptions.splice(deletedIndex, 1); // Remove the deleted item from the array
        }
        btn.closest("tr").remove();
      });
    });
  });
});

itemDescriptionBody?.addEventListener("keydown", function (event) {
  const target = event.target;
  if (target.classList.contains("cantEdit")) {
    target.readOnly = true;
  }
});

const wereHouseItemDescription = document.getElementById(
  "wereHouseItemDescription"
);
const wereHouseItemDescriptionBody = document.getElementById(
  "wereHouseItemDescriptionBody"
);

document.addEventListener("DOMContentLoaded", function () {
  let wereHouseSelectedOptions = [];

  wereHouseItemDescription?.addEventListener("change", function () {
    const wereHouseSelectedValue = wereHouseItemDescription.value;

    if (!wereHouseSelectedOptions.includes(wereHouseSelectedValue)) {
      wereHouseSelectedOptions.push(wereHouseSelectedValue);

      let html2 = `
              <tr>
                  <td class='pipe'><input class='pipe1 cantEdit' name="wereHouseItemName[]" value="${wereHouseSelectedValue}" readonly></td>
                  <td><textarea  class='pipecomitm' type="text" name="wereHouseComment[]"></textarea ></td>
                  <td><input class='pipiss' type="number" min="1" name="wereHouseItemQty[]"></td>
                  <td> <a class="deleteTr" ><i class="fa-sharp fa-solid fa-xmark"></i></a></td>
              </tr>
          `;

      wereHouseItemDescriptionBody?.insertAdjacentHTML("afterbegin", html2);
    }
    const deleteTr = document.querySelectorAll(".deleteTr");
    deleteTr?.forEach((btn) => {
      btn.addEventListener("click", () => {
        const deletedValue = btn.closest("tr").querySelector(".pipe1").value;
        const deletedIndex = wereHouseSelectedOptions.indexOf(deletedValue);
        if (deletedIndex !== -1) {
          wereHouseSelectedOptions.splice(deletedIndex, 1); // Remove the deleted item from the array
        }
        btn.closest("tr").remove();
      });
    });
  });
});

wereHouseItemDescriptionBody?.addEventListener("keydown", function (event) {
  const target2 = event.target;
  if (target2.classList.contains("cantEdit")) {
    target2.readOnly = true;
  }
});

const lengthValue = document.getElementById("length");
const width = document.getElementById("width");
const height = document.getElementById("height");
const boxResult = document.getElementById("boxResult");

const getBoxResult = function (dimensions) {
  if (lengthValue.value && width.value && height.value) {
    boxResult.innerHTML =
      dimensions[0].value * dimensions[1].value * dimensions[2].value + " m3";
  }
};

lengthValue?.addEventListener("change", function () {
  getBoxResult([lengthValue, width, height]);
});
width?.addEventListener("change", function () {
  getBoxResult([lengthValue, width, height]);
});
height?.addEventListener("change", function () {
  getBoxResult([lengthValue, width, height]);
});

const reject = document.getElementById("reject");
const rejectReason = document.getElementById("rejectReason");

reject?.addEventListener("click", function (e) {
  if (!rejectReason.required == true) {
    e.preventDefault();
    rejectReason.required = true;
  }
});

const executerDone = document.getElementById("executerDone");
const finishDate = document.getElementById("finishDate");

executerDone?.addEventListener("click", function (e) {
  if (!finishDate.required == true) {
    e.preventDefault();
    finishDate.required = true;
  }
});

const resendToInspector = document.getElementById("resendToInspector");
const resendNote = document.getElementById("resendNote");

resendToInspector?.addEventListener("click", function (e) {
  if (!resendNote.required == true) {
    e.preventDefault();
    resendNote.required = true;
  }
});

const printButton = document.getElementById("printButton");

printButton?.addEventListener("click", function () {
  window.print();
});

function notificationOn() {
  if (Notification.permission === "granted") {
    // Notifications are allowed
  } else if (Notification.permission !== "denied") {
    // Request permission to send notifications
    Notification.requestPermission()
      .then((permission) => {
        if (permission === "granted") {
          // Notifications are allowed
        }
      })
      .catch((error) => {
        console.error("Error requesting notification permission:", error);
      });
  } else {
    // The user has denied notification permission
    console.log(
      "You have denied notification permission. You can enable it in your browser settings."
    );
  }
}

function sendNotification(title, body, icon, url) {
  if ("Notification" in window) {
    // Check if notifications are allowed
    if (Notification.permission === "granted") {
      // Create and display a notification
      var notification = new Notification(title, {
        body: body,
        icon: icon, // You can specify an icon image
      });

      // Handle click event if the user interacts with the notification
      notification.onclick = function () {
        // Open the specified URL when the notification is clicked
        window.open(url, "_blank");
      };
    } else if (Notification.permission !== "denied") {
      // Request permission to send notifications (same as in the previous code)
      Notification.requestPermission()
        .then((permission) => {
          if (permission === "granted") {
            // You can send notifications here
          }
        })
        .catch((error) => {
          console.error("Error requesting notification permission:", error);
        });
    }
  }
}
