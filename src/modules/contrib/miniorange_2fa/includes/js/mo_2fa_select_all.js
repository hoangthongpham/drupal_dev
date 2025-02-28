(function ($) {
    function bindCheckboxEventHandlers() {
      $('#edit-select-all').on('change', function () {
        var isChecked = $(this).prop('checked');
  
        $('input[type="checkbox"].mo-auth-method-checkbox').each(function () {
          $(this).prop('checked', isChecked);
        });
      });
  
      $('input[type="checkbox"].mo-auth-method-checkbox').on('change', function () {
        var allChecked = true;
  
        $('input[type="checkbox"].mo-auth-method-checkbox').each(function () {
          if (!$(this).prop('checked')) {
            allChecked = false;
          }
        });
  
        $('#edit-select-all').prop('checked', allChecked);
      });
    }
  
    $(document).ready(function () {
      bindCheckboxEventHandlers();
  
      $(document).ajaxComplete(function () {
        bindCheckboxEventHandlers();
      });
    });
  })(jQuery);
  