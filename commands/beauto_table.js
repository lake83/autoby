var Nightmare = require('nightmare'),
    nightmare = Nightmare({show: false})
    url = process.argv[2];

nightmare
  .goto('https://beauto.com.ua' + url)
  .inject('js', 'vendor/bower/jquery/dist/jquery.min.js')
  .wait('#root .all-data .layout .col-lg-8')
  .evaluate(function () {
    var main = [];
    $('.main-modifiaction-info .col-sm-6:nth-child(2) .col-6').each(function() {
        var elem = {};
        elem.title = $(this).find('div:nth-child(1)').text();
        elem.value = $(this).find('div:nth-child(2)').text();
        main.push(elem);
    });
    $('.col-lg-8 .bottom-10:not(.h5)').each(function() {
        var elem = {};
        elem.title = $(this).find('div:nth-child(1)').text();
        if (elem.title.indexOf('Размер') !== -1) {
            var sizes = [];
            $(this).find('div:nth-child(2) div').each(function(){
                sizes.push($(this).text());
            });
            elem.value = sizes;
        } else {
            elem.value = $(this).find('div:nth-child(2)').text();
        }
        main.push(elem);
    });
    return main;
  })
  .end()
  .then(function (result) {
    return console.log(JSON.stringify(result, null, 4));
  })
  .catch(function (error) {
    console.error('Search failed:', error);
  });