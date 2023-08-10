const lengthValue = document.getElementById("length");
const width = document.getElementById("width");
const height = document.getElementById("height");
const boxResult = document.getElementById("boxResult");

const getBoxResult = function (dimensions) {
  if (lengthValue.value && width.value && height.value) {
    boxResult.innerHTML = dimensions[0].value * dimensions[1].value * dimensions[2].value + ' m3';
  }
};

lengthValue.addEventListener("change", function () {
  getBoxResult([lengthValue, width, height]);
});
width.addEventListener("change", function () {
  getBoxResult([lengthValue, width, height]);
});
height.addEventListener("change", function () {
  getBoxResult([lengthValue, width, height]);
});
