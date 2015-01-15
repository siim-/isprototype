$(function() {
  if ($('#datetimepicker').length > 0) {
    $('#datetimepicker').datetimepicker({
      inline:true,
      format:'Y-m-d H:i',
      value: $('#datetimepicker').val(),
      defaultSelect: false
    });
  }
})