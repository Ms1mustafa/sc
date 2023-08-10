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

userType.addEventListener('change', () => {
  if (userType.value == 'inspector') {
    areas.style.display = 'block';
  }
})

const ItemDescription = document.getElementById("ItemDescription");
const ItemDescriptionBody = document.getElementById("ItemDescriptionBody");

let Pipe, Clamp, Wood;
ItemDescription?.addEventListener("change", function () {
  if (ItemDescription.value == "Pipe 6M" && !Pipe) {
    let html = `
      <tr>
          <td class = 'pipe'>Pipe 6M</td>
          <td><input class = 'pipe1' type="number" min = "1" name="pipeQty"></td>
      </tr>
    `;

    ItemDescriptionBody.insertAdjacentHTML("afterbegin", html);
    Pipe = true;
  }
  if (ItemDescription.value == "Clamp movable" && !Clamp) {
    let html = `
      <tr>
          <td  class = 'clamp' >Clamp movable</td>
          <td><input  class = 'clamp1' type="number" min = "1" name="clampQty"></td>
      </tr>
    `;

    ItemDescriptionBody.insertAdjacentHTML("afterbegin", html);
    Clamp = true;
  }
  if (ItemDescription.value == "Wood 4m" && !Wood) {
    let html = `
      <tr>
          <td class = 'Wood'>Wood 4m</td>
          <td><input class = 'Wood1' type="number" min = "1" name="woodQty"></td>
      </tr>
    `;

    ItemDescriptionBody.insertAdjacentHTML("afterbegin", html);
    Wood = true;
  }
});

const reject = document.getElementById('reject');
const rejectReason = document.getElementById('rejectReason');

reject.addEventListener('click', function (e) {
  if (!rejectReason.required == true) {
    e.preventDefault();
    rejectReason.required = true
  }
})