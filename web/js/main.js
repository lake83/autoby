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
    
    //Show all car marks
    
    $('body').on('click', '.car-marks .car-mark.show-all', function(){
        var carMarksTop = $('.car-marks').offset().top - 20;
        event.preventDefault();
        
        $(this).find('.title').text($('.car-marks.all').is(':visible') ? 'Все марки' : 'Популярные марки');
        $('.car-marks.all').toggle();
        $('body,html').animate({scrollTop: carMarksTop}, 500);
    });
    $('body').on('click', '.car-models .car-model.show-all', function(){
        var carModelsTop = $('.car-models').offset().top - 20;
        event.preventDefault();
        
        $(this).find('.title').text($('.car-models.all').is(':visible') ? 'Все модели' : 'Показать меньше');
        $('.car-models.all').toggle();
        $('body,html').animate({scrollTop: carModelsTop}, 500);
    });
    
    $('body').on('click', '.car-marks .car-mark a, .car-logos a', function(){
        event.preventDefault();
        
        if ($('#auto_model').is(':disabled')){
            $('#brand').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        }
        $('.all-filters-anchor').trigger('click');
    });
    $('body').on('click', '.car-models .car-model a', function(){
        event.preventDefault();
        
        if ($('#auto_model').is(':enabled') && $('#generation').is(':disabled')) {
            $('#auto_model').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        }
        $('.all-filters-anchor').trigger('click');
    });
    
    $('#auto_model').on('depdrop:afterChange', function(event, id, value) {
        if (value && $('#auto_model').is(':enabled') && $('#generation').is(':disabled')) {
            $.post('/filter/select-list', {id: value, depth: 1}, function(data) {
                if (data){
                    $('.car-logos').remove();
                    sendButton(data.count);
                    $('#select-list').html(data.list);
                }
            });
        }
    });
    $('#generation').on('depdrop:afterChange', function(event, id, value) {
        if (value && $('#auto_model').is(':enabled') && $('#generation').is(':enabled')) {
            $.post('/filter/select-list', {id: value, depth: 0}, function(data) {
                $('#select-list').empty();
                if (data){
                    sendButton(data.count);
                }
            });
        }
    });
    
    function sendButton(count)
    {
        $('#select-list').empty();
        if (count === 0) {
            $('#ads-filter .blue-btn').hide();
            if (!$('.empty').length) {
                $('.btn-wrapper').append('<span class="empty">Ничего не найдено</span>');
            }
        } else {
            if ($('.empty').length) {
                $('.empty').remove();
            }
            if ($('#ads-filter .blue-btn').is(':hidden')) {
                $('#ads-filter .blue-btn').show();
            }
            $('#ads-filter .blue-btn').html(count);                  
        }
    }
    
    // Удаление пустых GET параметров при отправке формы фильтра и подстановка алиасов
    $('#ads-filter').submit(function () {
        var data = $(this).serializeArray().filter(function(item) {
            return !!item.value;
        });
        var params = jQuery.param(data);
        if (params.indexOf('brand') !== -1) {
            $.post('/filter/slug', {params: params}, function(data) {
                window.location = data;
            });
        } else {
            window.location = this.action + (params ? '?' + params : '');
        }
        return false;
    });
    
    // Сортировка объявлений моб. версия
    $('.sort-list a').click(function(){
        $('input[name=sort]').val($(this).attr('href'));
        $('#ads-filter').submit();
        return false;
    });
    
    //Show all car marks (END)
    
    //Show - Hide All-filters-anchor and animate to filters
        
    var filtersTop = $('#filters').offset().top + $('#filters').height(),
        scrTop = $(window).scrollTop();
    
    if (filtersTop < scrTop){
        $('.all-filters-anchor').addClass('active');
        $('.filters .m-all-filters').addClass('active');
        $('.footer').addClass('bottom');
    } else {
        $('.all-filters-anchor').removeClass('active');
        $('.filters .m-all-filters').removeClass('active');
        $('.footer').removeClass('bottom');
    }
    
    $(window).scroll(function (){
        var filtersTop = $('#filters').offset().top + $('#filters').height(),
        scrTop = $(window).scrollTop();
        
        if (filtersTop < scrTop) {
            $('.all-filters-anchor').addClass('active');
            $('.filters .m-all-filters').addClass('active');
            $('.footer').addClass('bottom');
        } else {
            $('.all-filters-anchor').removeClass('active');
            $('.filters .m-all-filters').removeClass('active');
            $('.footer').removeClass('bottom');
        }
    }); 
    
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
        $('.mobile-all-filters').addClass('open');
        $('.top-navigation .row').css('margin', '10px -10px 10px 0');
        $('.top-navigation .navigation-left, .top-navigation .navigation-right, .car-marks, .ads, footer, .reset-filters, .filters-wrapper .blue-btn, .mob-sort, .list-item').toggleClass('hidden-xs');
    });
    $('.mobile-all-filters .filter-cancel').click(function(){
        $('.filters .filters-group.more').addClass('hidden-xs');
        $('.mobile-all-filters').removeClass('open');
        $('.top-navigation .row').removeAttr('style');
        $('.top-navigation .navigation-left, .top-navigation .navigation-right, .car-marks, .ads, footer, .reset-filters, .filters-wrapper .blue-btn, .mob-sort, .list-item').toggleClass('hidden-xs');        
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