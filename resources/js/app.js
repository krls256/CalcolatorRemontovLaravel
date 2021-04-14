import 'slick-carousel';
import 'jquery.formstyler-modern';
import './modal';
import './searchError';
import './tooltip';
import 'jquery-lazy'

import 'jquery-mask-plugin';
import func from './calculator';
import Tabs from "./tabs.json";
import { add } from 'lodash';

const header    = $(".calc-prof__header");      // общий контейнер tabsbar-a
const tabsBlock = header.find(".edit > div");   // Сам койнтейнер tabs-ов
const content   = $(".calc-prof__content");     // Снипет койнтейнер
const footer    = $(".calc-prof__footer");      // Footer

var typeRem;
var countTabs = 0;

/** Окно видео */
const modalVideo = () => 
{
  $('.video__col').animatedModal({
    modalTarget: 'videoModal',
    animatedIn: 'fadeInDown',
    animatedOut: 'fadeOutUp',
    animationDuration: ".3s",
    color: "rgba(0, 0, 0, .3)",
    afterOpen: () => { 
      let $this = $("#videoModal");
      let id = $this.attr('data-id');

      $.ajax({
        type: 'POST',
        data: {id: id},
        cache: false,
        url: '/ajax/getVideo',
        success: (e) => func.getModalVideo(e) 
      });
    },
    afterClose: () => {
      let $this = $("#videoModal");
      $this.removeAttr('data-id');
      $this.find('.modal-layout .video-content').html('');
      $this.find('.loading-spinner').css('display', 'block')
    }
  });
}

const checkTabs = () => 
{
  let tabs          = tabsBlock.find('.tabs'),
      button        = footer.find("button.button__green");

  // Если вкладка появиась, то удаляем сообщение
  if ( countTabs > 0) {
    content.children('.empty').remove()
    button.removeClass("inactive");
  }

  // Если вкладок нет, выводим сообщение
  if ( !countTabs && !tabs.length) {
    content.html(`<div class="empty">Добавте комнату.</div>`)
    button.addClass("inactive");
  }
}

/**
 * Переключение вкладок
 *  
 * @param {*} e 
 */
const triggerTabs = e => 
{
  let tabs = e.data("tabs");  // Получаем id текущей вкладки

  if ( !e.hasClass('active') )
    tabsBlock.find(".tabs").removeClass("active"); 

  e.addClass("active");

  content.children(".active").removeClass("active");
  content.find('[data-card="' + tabs + '"]')
         .addClass("active");
}

/**
 * Добавляем карточки
 * 
 * @param {*} col 
 * @param {*} e 
 */
const AddSnippets = (col, e) => 
{
  let el      = Tabs.tabs[e],
      id      = col+1,
      parent  = $(`<div data-card="${id}" class="calc__content"></div>`),
      concat  = typeRem == 0 ? Tabs.new : Tabs.old,
      element = el['blocks'].concat(concat[e]['blocks']);
      
  for (let i=0; i <= element.length; i++) {
    let obj     = element[i],
        blocks  = $(`<div class="calc-block"></div>`);  

    parent.append(blocks);
    
    /* Получаем пункты блоков */
    $.map(obj, (val, i) => {
        let cont    = $(`<div class="wd-6 mwd-12"></div>`), 
            get;

      /* Добавляем отступ снизу для чекбокса */
      if (val['type'] == "checkbox") {
        blocks.addClass('padding-checkbox');
      }

      /* Добавляем заголовок пункту если это не чекбокс  */
      if (val['type'] != "checkbox") {
        cont.prepend(`<div class="calc__title">${val['title']}</div>`);
      }

      /* Отрисовываем элементы */
      switch (val['type']) {
                  
        // Выводим input
        case "input":
          let value = val['val'] != undefined ? `value="${val['val']}"` : '';
          get = `<label for="${val['name']}" class="input">
                      <input type="text" data-necessarily name="${el['name']}[${id}][${val['name']}]" ${value} id="${val['name']}" placeholder = "${val['placeholder']}" autocomplete="off">
                      <span>${val['value']}</span>
                  </label>`;
          break;
                  
        // Выбпадающие списки(select)
        case "select":
          let select = $(`<select name="${el['name']}[${id}][${val['name']}]" data-placeholder="Сделайте выбор">
              <option></option>
            </select>`);

          $.map(val['value'], (val, i) => select.append(`<option value="${val['name']}">${val['value']}</option>`))
          get = select;
          break;

        // Выводим переключатели
        case "trigger":
          let conteiner = $(`<div class="calc-trigger">
              <input type="hidden" name="${el['name']}[${id}]${val['name']}">
            </div>`);

          $.map(val['value'], (val, i) => conteiner.append(`<span data-val="${i}">${val['value']}</span>`));
          get =  conteiner;
          break;

        // Выводим чекбоксы
        case "checkbox":
          let checkbox = $(`<label class="checkbox">
              <input name="${el['name']}[${id}][still][${val['name']}]" type="checkbox" class="checkbox__input" value="${val['work']}">
            </label>`);

          checkbox.append('<div class="checkbox__block"><svg width="20px" height="20px" viewBox="0 0 20 20"><path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path><polyline points="4 11 8 15 16 6"></polyline></svg></div>');
          checkbox.append(`<span>${val['value']}</span>`);

          get =  checkbox;
          break;
      }

      cont.append(get);
      blocks.append(cont);
    });
  }

  content.append(parent);
  setTimeout(() => $("select").styler(), 1);
}

/**
 * Манипуляция контроллерами
 */
const controller = () => 
{
  let position  = tabsBlock.position(),
      scroll    = $(".edit").width() - tabsBlock.width(),
      dist      = 70,
      left      = position.left,
      next, back;
  
      /**
   * Если вкладки вылезают за приделы блока и кнопки дальше нет на странице то активируем её.
   * Если промотано до конца то скрываем некст.
   */
  if ( tabsBlock.width() > $(".edit").width() && $('.edit__controll-next').is(':hidden')) {
    next = "block";
  } else 
  if( scroll > left - dist*2 ) {
    next = "none";
  } 

  $('.edit__controll-next').css({display: next});

  if ( tabsBlock.width() > $(".edit").width() && left+dist < 0)
    back = "block";
  else 
    back = "none";

  $('.edit__controll-back').css({display: back});
}

/**
 * Создание вкладок
 * 
 * @param {*} e 
 */
const AddTabs = (e) => 
{
  let col = 1, elem;

  // Находим последнюю вкладуку
  tabsBlock.find(".tabs")
    .map( (e, i) => {
      let data = $(i).data("tabs");

      if (data>col) col = data;
    });
  
  countTabs++; 
  checkTabs();            // Вызываем проверку вкладок

  elem = $(`<span class="tabs" data-tabs="${col+1}">${Tabs.tabs[e]['title']}
              <i class="close"></i>
            </span>`);

  tabsBlock.append(elem);

  controller();
  AddSnippets(col, e)     // Создаем сниппет
  triggerTabs(elem)       // Делаем созданую вкладку активной
}

/**
 * Вывод ошибок
 * 
 * @param {*} text 
 * @param {*} type 
 */
const error  = (text, type = 'open') => 
{
  let block = footer.find('.error');

  if ( type == 'close' ) {
    block.remove();
    return;
  }

  if ( !block.length ) { 
    footer.prepend(`<div class="error">${text}</div>`);
  } else {
    block.text(text);
  }
}

// Run function at the window load
(() => {
  func.mobileMenu(); // Call check window width
  $('.lazy').Lazy();

  if (typeof WebFont != 'undefined') {
    WebFontConfig = {
      custom: {
        families: ['Open Sans']
      },
      active: function() {
        $('select, :checkbox, :radio').trigger('refresh');
      }
    };
    WebFont.load(WebFontConfig);
  }
})();

$(document).ready(function() {

  $('#send-application #phone').mask('+7 (000) 000-00-00', {
    placeholder: "+7 (___) ___-__-__"
  });

  /**
   * Останавливаем стандартное событие плагина.
   * Добавляем id компании в форму модального окна.
   * Самт вызываем открытие окна
   */
  $('.send-zamer').on('click', function() {
    let $this = $(this);
    let id = $this.data('id');

    $('#send-application [name="id"]').val(id);
  });

  // Добавляем ID в окно с видео
  $(document).on('click', '.video__col', function(){
    let $this = $(this); 
    let id = $this.data('id');

    $("#videoModal").attr('data-id', id);
  });

  // input focus active
  $(".input input").on({
    focus:      e => $(e.target).parent().addClass('active'),
    focusout:   e => $(e.target).parent().removeClass('active')
  });

  // Watch clicks at rooms box and type of premises
  $('.calc-trigger span, .calc-rooms span').on("click", function() {
    let $this = $(this),
        span = $this.parent();
    
    if($this.hasClass('active')) {
      span.children("input").val('');
    } else {
      span.children(".active").removeClass("active");
      span.children("input").val($this.data("val"));
    }

    $this.toggleClass('active');
    span.children("input").trigger('change');
  });

  // button to close menu
  $(document).on("click", ".header__button, .menu__close i", () => $('.menu').toggleClass('active'));

  // Smooth scroll
  $('.nextCard__button').on(`click`, function(e) {
      e.preventDefault();
      let positionElement = $($.attr(this, `href`)).offset().top;
    
      $(`body, html`).stop().animate({
          scrollTop: positionElement-60
      },600);
  });

  // Init slider slick
  $(".company-slider").slick({
    dots: true,
    infinite: true,
    speed: 300,
    arrows: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    adaptiveHeight: true,
    lazyLoad: 'ondemand',
    responsive: [{
      breakpoint: 750,
      settings: {
        arrows: false,
        variableWidth: false,
        slidesToShow: 1,
      }
    }, {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
      }
    }, {
      breakpoint: 950,
      settings: {
        slidesToShow: 3,
      }
    }]
  });

  $(".video__container").slick({
    infinite: false,
    adaptiveHeight: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    swipeToSlide: true,
    swipe: false,
    lazyLoad: 'ondemand',
    responsive: [{
      breakpoint: 950,
      settings: {
        slidesToShow: 3,
      }
    }, { 
      breakpoint: 750,
      settings: {
        slidesToShow: 2,
        swipe: true,
      }
    }, { 
      breakpoint: 580,
      settings: {
        swipe: true,
        slidesToShow: 1,
      }
    }]
  });
 
  // Обновляем селекты в легком калькуляторе в зависимости от типа помещения
  $('#calc-lite [name="type"]').on('change', function() {
    let val     = $(this).val();
    let change  = $('#calc-lite #typeRem');
    let html    = `<option></option>
                  <option value="0">После застройщика</option>
                  <option value="1">Капитальный</option>
                  <option value="2">Eвро</option>
                  <option value="3">Черновой (White box)</option>`;

    if ( val == 1 )
      html = `<option><option value="1">Капитальный</option><option value="2">Eвро</option><option value="4">Косметический</option>`;

    change.html(html);
    change.trigger('refresh');
  })

  // Выполняем запрос на подсчет в маленьком калькуляторе
  $("#calc-lite").on(`submit`, function(e) {
    e.preventDefault()

    let $this = $(this),
        check = $this.findError({parent: 'label, .styler'});

    if( !check ) return false;
    
    $.post("/ajax/lite", $this.serialize(), func.getCalculatorRating);
  });
  
  // Иницаализируем селекты с задержкой для правильно отображение шрифтов
  setTimeout( () => $("select").styler(), 1);

  const modal   = $('<a href="#calcWindow"></a>');

  modal.animatedModal({
    modalTarget: 'calcWindow',
    animatedIn: 'fadeInDown',
    animatedOut: 'fadeOutUp',
    animationDuration: ".3s",
    color: "rgba(0, 0, 0, .3)",
  });

  // Скролим вкладки вперед
  $(".edit__controll-next").on("click", function(){
    let left = tabsBlock.position().left,
        scroll   = $(".edit").width() - tabsBlock.width(),
        dist     = 70; 
    
    if ( scroll > ( left - dist*2) )
      left = scroll - left+(left+dist);

    tabsBlock.animate({"left": left - dist}, 300);
    controller();
  });

  // Скролим вкладки назад
  $(".edit__controll-back").on("click", function(){
    let left = tabsBlock.position().left,
        dist     = 70;

    if ( left+dist > -dist )
      left = -dist;

    tabsBlock.animate({"left": left + dist}, 300);
    controller();
  });
    
  // Переключение вкладок
  $(document).on("click", ".calc-prof__header .tabs", function() { 
    let $this = $(this);
    !$this.hasClass("active") && triggerTabs($this) 
  });

  // Удаление вкладок
  $(document).on("click", ".calc-prof__header .close", function(e) {
    e.stopPropagation();

    let tabs    = $(this).parent(),
        data    = tabs.data("tabs");

    tabs.remove();
    content.find(`[data-card="${data}"]`).remove();
    countTabs--; 
    checkTabs(); // Вызываем проверку вкладок
    
    !tabsBlock.find('.active').length && triggerTabs(tabsBlock.children().last());
  });

  // Если нет вкладок то, открываем окно для их добавления
  $('.calc-prof .button__blue').on('click', () => $('.calc-prof .add__button').trigger('click'));

  // Обработчик кнопок создания
  $(".add-tabs span").on("click", function() {
    AddTabs($(this).data("add"));
  });

  // Обработчик формы отправки
  $(".calc-prof").on("submit", function(e) {
    e.preventDefault();               // Снимаем стандартное событие
    if (countTabs <= 0) return false; // Если веладок нет то отменяем событие

    if ( !$(this).findError({parent: 'label'}) ) return false;
    
    $.post('/ajax/score', $(this).serialize(), func.getCalculatorRating);
  });

  // Отслеживаем изменение типа квартиры
  $('[name="all[type]"]').on('change', function() {

    error(false, 'close')
    typeRem = $(this).val();  

    let tabs = $('.edit > div').find('span');

    $.map(tabs, e => { 
      let data = $(e).data("tabs");
      $(e).remove();
      content.find(`[data-card="${data}"]`).remove();
    });
    $('.prof.rating').html('');
    countTabs=0; 
    checkTabs();
  });
    
  // Не даем создать вкладку пока не выбран тип помещения
  $('.add__button').on('click', e => {
    e.preventDefault();

    if ( $('.calc-prof [name="all[type]"]').val() == '') 
      return error('Выберете тип помощения.');

    modal.trigger('click')
  });

  // Раскрываем смету(Подробней)
  $(document).on('click', '.sum .estimate__price, .rating-price .estimate__price',function(){
    let $this   = $(this),
        parent  = $this.parent(),
        more    = $this.find('.estimate-header__more');

    //parent.find('.estimate__list').stop().toggle();

    if ( !parent.hasClass('active') ) {
      parent.addClass('active');
      more.text('Скрыть');
    } else {
      more.text('Подробнее');
      parent.removeClass('active');
    }
  });

  $('.open-full').on('click', function() { 
    let $this       = $(this),
        fullElement = $this.closest('[data-text]'),
        text        = fullElement.data('text');
    
    fullElement.find('.text-review').html(text);
    $this.remove();
  });

  // Открытие прайс листа по клику на цену
  $('.rating .rating__price').on('click', function() { 
    let el = $(this)
      .closest('.rating-price')
      .find('.estimate__price');

    el.trigger('click');
  });

  // Отправляем заявку
  $('#send-application').on('submit', function(e) { 
    e.preventDefault();

    let $this = $(this);
    let data  = $this.serialize();

    $.post('/ajax/sendApplication', data)
      .then((e) => { 
        let notif =  $this.find('.window-notif');

        if ( e.status == 'ok') {
          $this.find('input[type="text"]').val("");
          grecaptcha.reset();
          
          notif.addClass('success').text('Заявка отправлена успешно!');
        } else { 
          notif.addClass('error').text(e.message);
          grecaptcha.reset();
        }

        notif.css({display: "block"});
      });
  });

  const tooltip = { 
    open: function () { 

    },
    close: function () { 

    }
  }

  $('.info-conteiner').tooltip({ 
    distance: 75
  });
});

/**
 * После выполнения сериптов убераем колесико загрузки.
 * И повторно инициалезируем плагины модальных окон.
 */
window.onload = () => { 
  let load = document.getElementsByClassName('load');
  
  if (load.length) 
    load[0].style.display = 'none';

  modalVideo();
  func.modalApplication();
}

// Run function at the window resize
window.onresize = () => func.mobileMenu()
