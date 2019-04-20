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
        var carMarksTop = $('.car-marks').offset().top - 20, on = 'Все марки', off = 'Популярные марки';
        event.preventDefault();
        if ($('#filterform-auto_model').is(':enabled') && $('#filterform-generation').is(':disabled')) {
            on = 'Все модели'; off = 'Показать меньше';
        }
        $(this).find('.title').text($('.car-marks.all').is(':visible') ? on : off);
        $('.car-marks.all').toggle();
        $('body,html').animate({scrollTop: carMarksTop}, 500);
    });
    $('body').on('click', '.car-marks .car-mark a, .car-logos a', function(){
        event.preventDefault();
        if ($('#filterform-auto_model').is(':disabled')){
            $('#filterform-brand').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        }
        if ($('#filterform-auto_model').is(':enabled') && $('#filterform-generation').is(':disabled')) {
            $('#filterform-auto_model').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        }
        if ($('#filterform-auto_model').is(':enabled') && $('#filterform-generation').is(':enabled')) {
            $('#filterform-generation').val($(this).attr('href')).trigger('change.select2').trigger('select2:select');
        }
        $('.all-filters-anchor').trigger('click');
    });
    
    $('#filterform-auto_model, #filterform-generation').on('depdrop:afterChange', function(event, id, value) {
        if ($('#filterform-auto_model').is(':enabled') && $('#filterform-generation').is(':enabled')) {
            $('#select-list').empty();
        }
        if (value && $('#filterform-auto_model').is(':enabled') && $('#filterform-generation').is(':disabled')) {
            $.post('/filter/select-list', {id: value}, function(data) {
                if (data){
                    $('.car-logos').remove();
                    $('#ads-filter .blue-btn').html(data.count);
                    $('#select-list').html(data.list);
                }
            });
        }
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
        $('.top-navigation .navigation-left, .top-navigation .navigation-right, .car-marks, .ads, footer, .reset-filters, .filters-wrapper .blue-btn').toggleClass('hidden-xs');
    });
    $('.mobile-all-filters .filter-cancel').click(function(){
        $('.filters .filters-group.more').addClass('hidden-xs');
        $('.mobile-all-filters').removeClass('open');
        $('.top-navigation .row').removeAttr('style');
        $('.top-navigation .navigation-left, .top-navigation .navigation-right, .car-marks, .ads, footer, .reset-filters, .filters-wrapper .blue-btn').toggleClass('hidden-xs');        
    });
    $('.mobile-all-filters .filter-reset, .filters .reset-filters').click(function(){
        $('#ads-filter select').val(null).trigger('change.select2');
        $('#ads-filter')[0].reset();
        $('#filterform-auto_model, #filterform-generation').prop('disabled', true);
        
        $.get('/site/index', function(data) {
            $('#ads-filter .blue-btn').remove();
            $('#ads-filter .btn-wrapper').html($(data).find('#ads-filter .blue-btn'));
            $('#select-list').html($(data).find('#select-list'))
        });
        return false;
    });
    
    //Show - Hide mobile-all-filters (END)