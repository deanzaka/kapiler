var beras = document.getElementById("value");
var conv = document.getElementById("converse");

function convert() {
	var val = parseFloat(beras.value) || 0;
	conv.innerHTML = "Rp " + (val * 10000);
}

value.addEventListener("input", convert);