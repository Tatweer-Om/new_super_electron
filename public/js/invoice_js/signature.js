// For the first signature pad
var canvas1 = document.getElementById('signatureCanvas1');
var clearButton1 = document.getElementById('clearSignature1');
var signaturePad1 = new SignaturePad(canvas1);

clearButton1.addEventListener('click', function () {
    signaturePad1.clear();
});

// For the second signature pad
var canvas2 = document.getElementById('signatureCanvas2');
var clearButton2 = document.getElementById('clearSignature2');
var signaturePad2 = new SignaturePad(canvas2);

clearButton2.addEventListener('click', function () {
    signaturePad2.clear();
});
