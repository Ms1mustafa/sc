const itemDescription = document.getElementById("ItemDescription");
const itemDescriptionBody = document.getElementById("ItemDescriptionBody");
document.addEventListener("DOMContentLoaded", function () {

  let selectedOptions = [];

  itemDescription?.addEventListener("change", function () {
      const selectedValue = itemDescription.value;

      if (!selectedOptions.includes(selectedValue)) {
          selectedOptions.push(selectedValue);

          let html = `
              <tr>
                  <td class='pipe'><input class='pipe1 cantEdit' name="itemName[]" value="${selectedValue}" readonly></td>
                  <td><input class='pipe2' type="number" min="1" name="itemQty[]"></td>
              </tr>
          `;

          itemDescriptionBody?.insertAdjacentHTML("afterbegin", html);
      }
  });
});

itemDescriptionBody?.addEventListener("keydown", function (event) {
  const target = event.target;
  if (target.classList.contains("cantEdit")) {
    target.readOnly = true;
  }
});

const wereHouseItemDescription = document.getElementById("wereHouseItemDescription");
const wereHouseItemDescriptionBody = document.getElementById("wereHouseItemDescriptionBody");

document.addEventListener("DOMContentLoaded", function () {

  let wereHouseSelectedOptions = [];

  wereHouseItemDescription?.addEventListener("change", function () {
      const wereHouseSelectedValue = wereHouseItemDescription.value;

      if (!wereHouseSelectedOptions.includes(wereHouseSelectedValue)) {
          wereHouseSelectedOptions.push(wereHouseSelectedValue);

          let html2 = `
              <tr>
                  <td class='pipe'><input class='pipe1 cantEdit' name="wereHouseItemName[]" value="${wereHouseSelectedValue}" readonly></td>
                  <td><input class='pipe2' type="text" name="wereHouseComment[]"></td>
                  <td><input class='pipe2' type="number" min="1" name="wereHouseItemQty[]"></td>
              </tr>
          `;

          wereHouseItemDescriptionBody?.insertAdjacentHTML("afterbegin", html2);
      }
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

const reject = document.getElementById('reject');
const rejectReason = document.getElementById('rejectReason');

reject?.addEventListener('click', function (e) {
  if (!rejectReason.required == true) {
    e.preventDefault();
    rejectReason.required = true
  }
})

const executerDone = document.getElementById('executerDone');
const finishDate = document.getElementById('finishDate');

executerDone?.addEventListener('click', function (e) {
  if (!finishDate.required == true) {
    e.preventDefault();
    finishDate.required = true
  }
})