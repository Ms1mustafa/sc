var fs = require("fs");

var jsObfuscator = require("javascript-obfuscator");

fs.readFile("./script.js", "UTF-8", function (error, code) {
  if (error) {
    throw error;
  }

  var obfuscateResult = jsObfuscator.obfuscate(code);

  fs.writeFile(
    "./scriptt.js",
    obfuscateResult.getObfuscatedCode(),
    function (fsError) {
      if (fsError) {
        throw fsError;
      }
    }
  );
});
