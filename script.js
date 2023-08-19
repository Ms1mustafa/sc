document.addEventListener("DOMContentLoaded", function () {
  const itemDescription = document.getElementById("ItemDescription");
  const itemDescriptionBody = document.getElementById("ItemDescriptionBody");

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

const userType = document.getElementById("userType");
const areas = document.getElementById("areas");

userType?.addEventListener('change', () => {
  if (userType.value == 'inspector') {
    areas.style.display = 'block';
  }
})

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


