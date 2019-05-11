// Burger  
        
    $(".navbar-header .navbar-toggle").on("click", function () {
        $(this).toggleClass("active");
        $(this).parent().toggleClass("active");
        
        $('.header-menu-wrapper').toggleClass("open");
    });     
    $(".header-menu-wrapper .header-bg").on("click", function () {
        $('.navbar-header .navbar-toggle').toggleClass("active");
        $('.navbar-header .navbar-toggle').parent().toggleClass("active");
        
        $('.header-menu-wrapper').toggleClass("open");
    });    
        
// Burger (END) 
    
    // Показать все марки
    $('body').on('click', '.car-marks .car-mark.show-all', function(){
        var carMarksTop = $('.car-marks').offset().top - 20;
        event.preventDefault();
        
        $(this).find('.title').text($('.car-marks.all').is(':visible') ? 'Все марки' : 'Популярные марки');
        $('.car-marks.all').toggle();
        $('body,html').animate({scrollTop: carMarksTop}, 500);
    });
    
    // Показать все модели
    $('body').on('click', '.car-models .car-model.show-all', function(){
        var carModelsTop = $('.car-models').offset().top - 20;
        event.preventDefault();
        
        $(this).find('.title').text($('.car-models.all').is(':visible') ? 'Все модели' : 'Показать меньше');
        $('.car-models.all').toggle();
        $('body,html').animate({scrollTop: carModelsTop}, 500);
    });
    
    // Переключить марку
    $('body').on('click', '.car-marks .car-mark a, .car-logos a', function(){
        event.preventDefault();
        
        if ($('#auto_model').is(':disabled')){
            $('#brand').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        }
        $('.all-filters-anchor').trigger('click');
    });
    
    // Переключить модель
    $('body').on('click', '.car-models .car-model a', function(){
        event.preventDefault();
        
        $('#auto_model').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        $('#select-list').empty();
        $('.all-filters-anchor').trigger('click');
    });
    
    // Вывод кнопки и удаление списков зависимо от к-тва результатов фильтра
    $('#ads-filter select, #ads-filter input, #locations').on('change', function () {
        filterCount();
    });
    
    function filterCount()
    {
        if ($('#ads-filter').length) {
            var params = filterParams('#ads-filter');
            $('#ads-filter').attr('data-params', params);
            if (params && params != $('#ads-filter').attr('data-params')) {
                $.ajaxSetup({async: false});
                $.post('/filter/ads-count', {params: params}, function(data) {
                    if (data === 0) {
                        $('#ads-filter .blue-btn').hide();
                        if (!$('.btn-wrapper .empty').length) {
                            $('.btn-wrapper').append('<span class="empty">Ничего не найдено</span>');
                        }
                        $('#select-list').empty();
                        } else {
                        if ($('.btn-wrapper .empty').length) {
                            $('.btn-wrapper .empty').remove();
                        }
                        if ($('#ads-filter .blue-btn').is(':hidden')) {
                            $('#ads-filter .blue-btn').show();
                        }
                        $('#ads-filter .blue-btn').html(data);                  
                    }
                });
            }
        }
    }
    
    // Получить и вывести список моделей
    $('#auto_model').on('depdrop:afterChange', function(event, id, value) {
        if ($('#ads-filter').attr('action') == '/cars/all') {
            var params = $('#ads-filter').attr('data-params');
            if (params.indexOf('brand') !== -1 && params.indexOf('auto_model') !== -1) {
                $('#select-list').empty();
            }
            if (value && params.indexOf('auto_model') == -1 && !$('.btn-wrapper .empty').length) {
                $('#select-list').hide();
                $.post('/filter/select-list', {id: value}, function(data) {
                    if (data){
                        $('.car-logos').remove();
                        $('#select-list').html(data);
                        $('#select-list').show();
                        filterCount();
                    }
                });
            }
        }
    });
    
    // Удаление пустых GET параметров при отправке формы фильтра и подстановка алиасов
    $('#ads-filter').on('beforeSubmit', function() {
        var params = filterParams('#ads-filter');
        if (params.indexOf('brand') !== -1) {
            $.post('/filter/slug', {params: params}, function(data) {
                window.location = data;
            });
        } else {
            window.location = this.action + (params ? '?' + params : '');
        }
        return false;
    });
    
    // Нельзя отправить форму на странице каталога если не выбраны все значения, преобразование URL
    $('#catalog-filter').on('beforeSubmit', function() {
        var params = filterParams('#catalog-filter');
        if (params.indexOf('type') !== -1) {
            $.post('/filter/catalog-slug', {params: params}, function(data) {
                window.location = data;
            });          
        }
        return false;
    });
    
    // Форма авторизации пользователя, отправка SMS
    $('#user-login').on('beforeSubmit', function() {
        if ($(this).find('.has-error').length === 0 && ($('.sms-block').hasClass('hide') || $('.repeat-send-code').hasClass('hide'))) {
            $.post($(this).attr('action'), {phone: $('#loginform-phone').val()}, function(data) {
                if (data) {
                    $('.sms-block').removeClass('hide');
                    $('#user-login .send').attr('disabled', true);
                }
            });
            return false;         
        }
    });
    
    // Форма авторизации пользователя
    $('#loginform-sms').on('keyup', function() {
        if ($(this).val().length == 4) {
            $('#user-login').submit();
        }
    });
    
    // Задержка отправки повторного SMS
    $('.repeat-send-code').on('click', function() {
        var n = 60;
        $('#user-login').submit();
        $(this).addClass('hide');
        $('.field-loginform-sms').append('<div id="new_sms">Повторно можно будет отправить через: <span>' + n + '</span> c</div>');
        setTimeout(countDown,1000);
        function countDown()
        {
            n--;
            if (n > 0){
                setTimeout(countDown,1000);
                $('#new_sms span').text(n);
            } else {
                $('#new_sms').remove();
                $('.repeat-send-code').removeClass('hide');
            }
        }
        return false;
    });
    
    // Вывод спецификаций
    $('.engine-type ul li a').on('click', function() {
        $('.engine-type ul li').removeClass('active');
        $.post(window.location.href, {id: $(this).attr('href')}, function(data) {
            $('#specification').html(data);
        });
        $(this).closest('li.list-item').addClass('active');
        return false;
    });
    
    // Сбор параметров фильтра
    function filterParams(form)
    {
        var form = $(form).serializeArray().filter(function(item) {
            return !!item.value;
        });
        return $.param(form);
    }
    
    // Сортировка объявлений моб. версия
    $('.sort-list a').click(function(){
        $('input[name=sort]').val($(this).attr('href'));
        $('#ads-filter').submit();
        return false;
    });
    
    // Продолжить при создании объявления
    $('#create-ad .continue').click(function(){
        $('#create-ad .step.hidden, #create-ad .continue-wrapper.hidden').removeClass('hidden');
        $('#create-ad .continue-wrapper.more').addClass('hidden');
    });
    
    // Сортировка изображений объявления
    $('#image').on('filesorted', function(event, params) {
        var images = [];
        $.each(params.stack, function(key, value) {
            images.push(value.key);
        });
        $.post('/client/sort-image?ad_id=' + $('#create-ad').data('ad_id'), {images: images.join(',')}, function(data) {
            if (data) {
                $('.file-preview-status.text-success').html('<p class="msg-success"><button type="button" class="close"><span aria-hidden="true" onclick="$(\'.msg-success\').remove()">×</span></button>Изменение позиции сохранено.</p>');
            }
        });
    });
    
//Show - Hide All-filters-anchor and animate to filters
    filterScroll();
    
    $(window).scroll(function (){
        filterScroll();
    });
    
    function filterScroll()
    {
        if ($('#filters').length) {
            var filtersTop = $('#filters').offset().top + $('#filters').height(), scrTop = $(window).scrollTop();
    
            if (filtersTop < scrTop){
                $('.all-filters-anchor').addClass('active');
                $('.filters .m-all-filters').addClass('active');
                $('.footer').addClass('bottom');
            } else {
                $('.all-filters-anchor').removeClass('active');
                $('.filters .m-all-filters').removeClass('active');
                $('.footer').removeClass('bottom');
            }
        }
    }
    
    $('.all-filters-anchor').on('click', function(event) {
        event.preventDefault();
        var id  = $(this).data('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 500);
    });
    
//Show - Hide All-filters-anchor and animate to filters (END)
    
//Show - Hide mobile-all-filters
    
    $('.filters .filters-wrapper .m-all-filters').click(function(){
        $('.filters .filters-group.more').removeClass('hidden-xs');
        $('.mobile-all-filters, #filters').addClass('open');
        $('.top-navigation .row').css('margin', '10px -10px 10px 0');
        $('.top-navigation .navigation-left, .top-navigation .navigation-right, .car-marks, .news, footer, .reset-filters, .filters-wrapper .blue-btn, .mob-sort, .list-item, #select-list').toggleClass('hidden-xs');
    });
    $('.mobile-all-filters .filter-cancel').click(function(){
        $('.filters .filters-group.more').addClass('hidden-xs');
        $('.mobile-all-filters, #filters').removeClass('open');
        $('.top-navigation .row').removeAttr('style');
        $('.top-navigation .navigation-left, .top-navigation .navigation-right, .car-marks, .news, footer, .reset-filters, .filters-wrapper .blue-btn, .mob-sort, .list-item, #select-list').toggleClass('hidden-xs');        
    });
    $('.mobile-all-filters a.filter-reset, .filters .reset-filters a').click(function(){
        if ($(this).attr('href') == '#') {
            $('#ads-filter select').val(null).trigger('change.select2');
            $('#ads-filter')[0].reset();
            $('#auto_model, #generation').prop('disabled', true);
        
            $.get('/site/index', function(data) {
                $('#ads-filter .blue-btn').remove();
                $('#ads-filter .btn-wrapper').html($(data).find('#ads-filter .blue-btn'));
                $('#select-list').html($(data).find('#select-list'));
                $('.filters-wrapper .blue-btn').toggleClass('hidden-xs');
            });
            return false;
        }
    });
    
//Show - Hide mobile-all-filters (END)