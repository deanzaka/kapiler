// var beras = document.getElementById("value");
// var conv = document.getElementById("converse");

// function convert() {
// 	var val = parseFloat(beras.value) || 0;
// 	conv.innerHTML = (val * 10000);
// }

// value.addEventListener("input", convert);

$("#value").keyup(function() {
       var val = $("#value").val() || 0;
       $("#converse").html(parseFloat(val) * 10000);
});

$("#value").keyup(function() {
    $("#value").val(this.value.match(/[0-9]*/));
});
