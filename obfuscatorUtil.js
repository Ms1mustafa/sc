const fs = require("fs");
const jsObfuscator = require("javascript-obfuscator");

function obfuscateAndSave(inputFilePath, outputFilePath) {
  fs.readFile(inputFilePath, "UTF-8", (error, code) => {
    if (error) {
      throw error;
    }

    const obfuscateResult = jsObfuscator.obfuscate(code);

    fs.writeFile(
      outputFilePath,
      obfuscateResult.getObfuscatedCode(),
      (fsError) => {
        if (fsError) {
          throw fsError;
        }
        console.log(
          `JavaScript file obfuscated and saved to ${outputFilePath}`
        );
      }
    );
  });
}

// Call the function with input and output file paths
obfuscateAndSave("./script_main.js", "./script.js");
obfuscateAndSave("./getData.js", "./gndt.js");
