import '@chenfengyuan/datepicker';
import '@chenfengyuan/datepicker/i18n/datepicker.ru-RU';
import 'jquery-mask-plugin';
import 'jquery.formstyler-modern';
import 'trumbowyg'
import path from 'path'
import axios from 'axios'

/**
 * Убераем все сообщения об ошибке
 * 
 * @param {*} e 
 */
const errorClose = (e) => { 
  $(e).find('.active').removeClass('active');
  $(e).find('.input').removeClass('error');
}

/**
 * Обрабатываем ответ при создании сметы
 * 
 * @param {*} data 
 */
const addEstimate = ({ data }) => {

  if ( data.code == 'success') {
    window.location = '/admin/estimates';
  } else 
  if ( data.type == 'validation') {
    console.log(data.message);
  }
} 

$(document).ready(function() {

  /* input focus active*/
  $(".input input").on({
    focus: e => {
        $(e.target).parent().addClass('active')
    },
    focusout: e => {
        $(e.target).parent().removeClass('active')
    }
  });

  // Форма авторизации
  $("#login-form").on('submit', function(e){
    e.preventDefault();

    let error = $('.screen-info');
    errorClose(this);

    axios.post("/ajax/sign_in", $(this).serialize())
      .then(req => {
        let { data } = req;

        if (data.status == 'ok') { 
          window.location = '/admin';
        } else 
        if ( data.status == 'error' && data.type == 'auth') {
          error.text('Логин или пароль введены не верно!');
          error.addClass('active');
        } else
        if ( data.status == 'error' && data.type == 'validation') {
          $.each(data.message, function (e) { 
            $('[for="' + e + '"]').addClass('error');
          });
          
          error.text('Некоторые поля заполнены не коректно!');
          error.addClass('active');
        }
      });
    
  });

  // Удаляем сообщения об ошибках при вводе.
  $("#login-form input").on('input', function () { 
      errorClose("#login-form");
  });

  // Дата создания
  $('.create_company').datepicker({
      language: 'ru-RU',
      format: 'dd.MM.YYYY',
      pickedClass: 'picked'
    })
  .mask('00.00.0000');

  $('[name="phone"]').mask('+7 (000) 000-00-00');
  $('.file input, #role, #company, #profile, #measure, #type').styler();

  // Поле описания компании
  $('#add-company-form #discription, #edit-company-form #discription').trumbowyg({
    svgPath: path.join(__dirname, 'static/images/icons.svg')
  });

  // Добавляем компанию
  $('#add-company-form').on('submit', function(e) {
    e.preventDefault();

    axios.post('/ajax/company/add', new FormData($(this)[0]))
      .then(req => {
        let { data } = req;
        
        if ( data.status == 'ok') {
          window.location = '/admin/companies';
        }
      });
  });

  // Редактирование компании
  $('#edit-company-form').on('submit', function(e) {
    e.preventDefault();

    axios.post('/ajax/company/edit', new FormData($(this)[0]))
      .then(req => {
        let { data } = req;
        
        if ( data.status == 'ok') {
          window.location = '/admin/companies';
        }
      });
  });
  
  // Создание пользователя
  $('#add-user-form').on('submit', function(e) {
    e.preventDefault();

    axios.post('/ajax/users/add', $(this).serialize())
      .then(res => {
        let { data } = res;
        
        if ( data.status == 'ok') {
          window.location = '/admin/users/'
        }
      });
  });

  // Создание смету
  $('#add-estimates-form').on('submit', function(e) {
    e.preventDefault();
    axios.post('/ajax/estimates/add', $(this).serialize())
      .then(res => addEstimate(res));
  });

  // Создание пользователя
  $('#edit-estimates-form').on('submit', function(e) {
    e.preventDefault();
    axios.post('/ajax/estimates/edit', $(this).serialize())
      .then(res => {
        let { data } = res;

        if ( data.code == 'ok') {
          window.location = '/admin/estimates';
        }
      });
  
  });

  /**
   * Добавление прайса 
   */
  $(document).on('submit', '#edit-price-form', function(e) { 
    e.preventDefault();

    let $this = $(this);
    let data  = $this.serialize();

    $.ajax({
      type: 'POST',
      cache: false,
      data: data,
      url: '/ajax/price/add', 
      success: (e) => { 
        if (e.code == 'ok') {
          let measure;
          let list = $this.closest('.content').find('#list');

          switch (e.data.measure) {
            case '2':
              measure = 'шт.'
              break;
            case '3':
              measure = 'м/п'
              break;
            default:
              measure = 'м²'
              break;
          }

          let block = $(`<div class="box flex box-list th price-list">
                            <div class="col-8">${e.data.title}</div>
                            <div class="col-2">${e.data.price} руб.</div>
                            <div class="col-1">${measure}</div>
                            <div class="col-1">
                              <a href="/admin/price/del/${e.data.id}" >
                                <svg viewBox="0 0 329.26933 329" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0" fill="#9e9e9e" /></svg>
                              </a>
                            </div>
                          </div>`);

          if ( list.find('.notice').length > 0 )
            list.find('.notice').remove();
      
          list.append(block);

          $this.find('input[type="text"]').val('');
        }
      }
    });
  });

  $(document).on('click', '.price-list a', function(e) {
    e.preventDefault();

    let $this = $(this); 
    let url   = $this.attr('href'); 
    $.ajax({
      type: "POST",
      url: url,
      cache: false,
      success: (e) => { 
        if(e.code == 'ok') { 
          $this.closest('.price-list').remove();
        }
      }
    });
  });
});