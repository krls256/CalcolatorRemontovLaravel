import Tabs from "./tabs.json";

/**
 * Полная стоимость
 * 
 * @param {*} array 
 */
const total = ( array ) => {
  var price = 0;

  $.each(array, (i, get) =>
    price += (get.length > 0) ? total( get ) : !(get instanceof Array) && get.price
  );

  return price;
}


/**
 * Menu Control funciton
 */
const mobileMenu = () => {

  let width       = window.innerWidth, // Get window width
      menu        = document.getElementsByClassName("menu")[0],   // Get menu object
      panelMenu   = document.querySelector(".menu > .menu__close"); // Get menu button object

  /**
   * If the window width is less 750 pixeles then add a mobile menu bar
   * Сheck a mobile menu panel
   * Created the panel 
   * If the window width is more 750 pixeles then remove a mobile menu bar
   */
  if (width <= 750) {
    if ( !panelMenu ) {
      let elem = document.createElement('li');

      menu.style.transition = ".5s cubic-bezier(0, 0.55, 1, 0.75)";
      elem.className = "menu__close";
      elem.innerHTML = "Калькулятор ремонта<i></i>";

      menu.prepend(elem)
    }
  } else {
    if (panelMenu) {
      menu.removeChild(panelMenu);
      menu.removeAttribute("style"); 
    }
  }
}

const getRating = (n) => { 
  let container = $('<div class="star-rating"></div>');

  for(let i = 1; i <= 5; i++){
    if (n >= i) {
      container.append(`<span class="complete"></span>`);
    } else
    if ( n < i && n+1 > i) { 
      let x = n - Math.trunc(n);
    
      if ( x < 0.3 ) {
        container.append(`<span class="empty"></span>`)
      } else
      if( x > 0.7 ) {
        container.append(`<span class="complete"></span>`);
      } else {
        container.append(`<span class="half"></span>`);
      } 
    } else { 
      container.append(`<span class="empty"></span>`)
    }
  }

  return container;
}

const getModalVideo = (e) => { 
  let $this         = $('#videoModal'),
      contentBlock  = $this.find('.modal-layout .video-content'),
      video         = $(`<iframe width="100%" frameborder="0" scrolling="auto" class="video-container" allowfullscreen></iframe>`),
      block         = $('<div class="video-info"></div>'),
      rating        = getRating(e.company.rating).get(0);

  video.attr('src', `https://www.youtube.com/embed/${ e.video_id }?&showinfo=0`);
  contentBlock.append(video);

  block.append(`<div class="video-info__title">${ e.name }</div>`);
  block.append(`<span class="video-info__published">Опубликовано: ${ e.publishedAt }</span>`);
  block.append(`<div class="video-info__company">
                  <img src="${ e.company.logo }" alt="${ e.company.name }"/>
                  <div class="company-info">
                    <a href="/rating/${ e.company.url }">${ e.company.name }</a>
                    <div><span>Оценка:</span>${ rating.outerHTML }</div>
                  </div>
                </div>`);

  contentBlock.append(block);
  $this.find('.loading-spinner').css('display', 'none');
}

/**
 * Выводим список цен
 * 
 * @param {*} array 
 */
const visablePrice = ( array ) => {
  let list = $(`<div class="estimate__list"></div>`);

  $.map(array, (data, type) => {

    if ( data.length == 0) return false; 

    let price;
    let item        = $(`<div class="estimate__item"></div>`);
    let className   = '';

    type  = (typeof type == 'number') ? data.type : type;
    let name  = (type === 'still') ? 'name' : data.name;
    
    if (data.length == 0) {
      price = `<i>Не указан.</i>`;
    } else 
    if ( data.price == 0 ) {
      price = `<i>Цена не указана!</i>`
    } else
    if (data instanceof Array) {
      price = visablePrice(data, 'sub')[0].outerHTML;
      className = 'sub';
    } else {
      price = `<span>${ data.dimension }</span><span>${ data.metric }</span><i>${data.price} руб.</i>`;
    }

    item.append(`<div class="${className}"><span>${Tabs.list[type][name]}</span> ${price}</div>`);
    list.append(item);
  });
  
  return list;
}

/* Окно замеров */
const modalApplication = () => 
{
  $('.send-zamer').animatedModal({ 
    animatedIn: 'fadeInDown',
    animatedOut: 'fadeOutUp',
    animationDuration: ".3s",
    color: "rgba(0, 0, 0, .3)",
    beforeClose: function() { 
      $('#send-application [name="id"]').val('');
      $('#send-application .window-notif')
        .css({ display: "none"})
        .text('')
        .removeClass()
        .addClass('window-notif');
    }
  });
}

/**
 * Выводим рейтинг из подсчитаных данных
 * 
 * @param {*} data 
 */
const getCalculatorRating = data => {
  let rating = $('.prof.rating').html('');

  // Перебераем клмпании
  $.map(data, (e) => {
    const {details, img, name, url, price, id} = e;

    let block = $(`<div class="module calc__rating">
                    <div class="rating__block">
                      <div class="rating__img"><img src="${img}" alt="${name}"></div>
                      <div class="rating__name">
                        <a href="/rating/${url}/" target="_blank">${name}</a>
                        <div class="rating__price">Цена:&nbsp;<span>${price}</span>&nbsp;руб.</div>
                      </div>
                      <div class="rating__sand">
                        <a href="#animatedModal" class="link-button send-zamer" data-id="${id}">Оставить заявку</a>
                      </div>
                    </div>
                  </div>`);

    let sum   = $('<div class="sum"></div>');

    $.map(details, (room, name) => {
      $.map(room, (e, i) => {
        let price = total(e);

        let estimate = $(`<div class="estimate">
            <div class="estimate__price estimate-header">
              <span class="estimate-header__name">${Tabs.name[name]} ${i+1}</span>
              <span class="estimate-header__title">Кол-во.</span>
              <span class="estimate-header__title">Ед. измерения</span>
              <span class="estimate-header__more">Подробнее</span>
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744 L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284 c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z" fill="#dcdcdc"></path></svg>
            </div>
          </div>`).appendTo(sum);

        let list = visablePrice(e);

        list.append(`<div class="estimate__result">
                        <strong>Итого:</strong> 
                        <i>${(price).toLocaleString('ru-RU')}</i> руб.
                     </div>`);

        estimate.append(list);
      });
    });

    block.append(sum);
    rating.append(block);

    $(`body, html`).stop().animate({
      scrollTop: $('#rating').offset().top-75
    },600);

    modalApplication();
  });
} 

export default {
  total,
  mobileMenu,
  getRating,
  getModalVideo, 
  visablePrice,
  getCalculatorRating,
  modalApplication
}