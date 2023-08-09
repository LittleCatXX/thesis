const scannerInput = document.getElementById('scannerInput');
const scannedValuesContainer = document.getElementById('scannedValues');

let currentScannedValue = '';

scannerInput.addEventListener('input', event => {
  const inputValue = event.target.value;

  // Check if the input value contains a complete scan (e.g., terminated by Enter key)
  if (inputValue.includes('\n')) {
    const scannedValue = inputValue.trim(); // Remove leading/trailing whitespace and newline
    addScannedValue(scannedValue);
    currentScannedValue = ''; // Reset current scanned value
    scannerInput.value = ''; // Clear the input field
  } else {
    currentScannedValue = inputValue;
  }
});

function addScannedValue(value) {
  const scannedValueElement = document.createElement('p');
  scannedValueElement.textContent = value;
  scannedValuesContainer.appendChild(scannedValueElement);
}
