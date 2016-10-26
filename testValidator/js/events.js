
// var test = document.getElementById("testID");

// function validate() {
// 	testID.val(this.value.match(/[0-9]*/));
// 	console.log("======test=======");
// }

// testID.addEventListener("keyup", validate);

// $("#testID").keyup(function() {
//     $("#testID").val(this.value.match(/[0-9]*/));
//     console.log("TEST");
// });

$("#testID").focusout(function() {
	var cond = $("#testID").val().match(/^[a-zA-Z\s\.\']+$/);
	console.log(cond);
	if(cond == null) {
		$("#testID").css("background-color", "red");
	} else {
		$("#testID").css("background-color", "green");
	}
	//$("#testID").val(this.value.match(/^[a-zA-Z\s\.\']+$/));
});