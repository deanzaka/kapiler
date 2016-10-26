$("#value").keyup(function() {
       var val = $("#value").val() || 0;
       $("#converse").html(parseFloat(val) * 10000);
});

$("#value").keyup(function() {
    $("#value").val(this.value.match(/[0-9]*/));
});
