(function($) { 
    $.fn.tooltip = function ( options ) { 
        
        var $this       = $(this),
            settings    = $.extend({
                target:     '.tooltip',
                event:      'click',
                scroll:     $(window),
                distance:   0
            }, options);

        var menthods = {
            // Отерываем tooltip при выполнении событии
            open: function (e) { 
                var text        = e.data('text');
            
                $this.text(text);           // Вставляем текст в туалтип
                menthods.position(e);
                $this.addClass('active');   // Открываем
            }, 

            // Закрываем tooltip при сробатывании события закрытия
            close: function () { 
                $this.removeClass('active');    // Закрываем tooltip
                $this.css({left: 0, top: 0});   // Обноляем позиционирование
                $this.text('');                 // Очищаем текст
            },

            // Позиционирование tooltip
            position: function(e) { 
                var positionTop,
                    positionLeft,
                    height      = e.outerHeight(),              // Получаем высоту элемента
                    width       = e.outerWidth(),               // Получаем ширену элемента
                    offset      = e.offset(),                   // Пизиционирование элемента
                    scroll      = settings.scroll.scrollTop(),  // Получаем scrollTop контейнера
                    distance    = (offset.top - scroll),        // Растояние от верха окна до элемента
                    thisHeight  = $this.outerHeight(),          // Высота tooltip
                    thisWidth   = $this.outerWidth(),
                    rt          = (settings.scroll.outerWidth() - offset.left);

                // В зависимости от скрола окна отерываем tooltip над или под пунктом
                if (distance > thisHeight + settings.distance) { 
                    positionTop = offset.top - thisHeight;
                } else { 
                    positionTop = (offset.top + height);
                }

                positionLeft = offset.left;
           
                if (  rt > 300 ) { 
                    positionLeft = offset.left
                } else { 
                    positionLeft = ((offset.left - thisWidth/2) + width);
                }
  
                // Пизиционируем tooltip
                $this.css({ 
                    top: positionTop,
                    left: positionLeft
                });
            }, 

            // Вызывается при изменении размеров окна
            resize: function(e) {
                // Вызываем фушкцию позиционирования
                menthods.position(e)
            },
            // в случаии необходимости разрушаем туалтип
            destroy: function() {
                $(window).unbind($this);
            }  
        }
        
        // Событие открытия
        $(document).on(settings.event, settings.target, function() {
            var eventThis = $(this);

            if (!$this.hasClass('active')) {
                menthods.open(eventThis);
            } else { 
                menthods.close();
            }
            
            // Меняем положение tooltip при изменении размера браузера
            (settings.scroll).on('resize', function() { 
                menthods.resize(eventThis)
            });

            // Закрываем tooltip событии за приделми туалтипа или элемента вызывающего его
            $(document).on(settings.event, 'body, html', function(e) { 
                if ( !eventThis.is(e.target) && eventThis.has(e.target) && !$this.is(e.target) && $this.has(e.target) )
                    menthods.close();
            });
        });

        return menthods;
    } 
})(jQuery)