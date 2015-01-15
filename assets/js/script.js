$(function() {
  if ($('#datetimepicker').length > 0) {
    $('#datetimepicker').datetimepicker({
      inline:true,
      format:'Y-m-d H:i',
      startDate: $('#datetimepicker').val(),
      defaultSelect: false
    });
  }
  if ($('#datetimepicker2').length > 0) {
    $('#datetimepicker2').datetimepicker({
      inline:true,
      format:'Y-m-d H:i',
      startDate: $('#datetimepicker2').val(),
      defaultSelect: false
    });
  }
})