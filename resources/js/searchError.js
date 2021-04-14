/**
 * Плагин для поиска полей с пустыми полями
 */
(function( $ ) {
    $.fn.findError = function( options ) {
  
      var setting = $.extend({}, options);
      let status  = true;
      let list    = this.find("[data-necessarily]");
  
      // Ищем все поля для котороых нужно провести тест.
      $.map(list, function(e) {
        let $this = $(e);
  
        if($this.val().length == 0 || $this.val() == '') {
          let show = !setting.parent ? $this : $this.closest(setting.parent);
          show.addClass('findError');
          status = false;
        }
      });
  
      // Снимаем error со всех input.
      $(document).on('input, change', `.findError [data-necessarily], .findError`, function() {
        let show = !setting.parent ? $(this) : $(this).closest(setting.parent);
        show.removeClass('findError');
      });
  
      return status;
    }
})(jQuery);