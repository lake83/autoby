var Nightmare = require('nightmare'),
    nightmare = Nightmare({show: false})
    url = process.argv[2];

nightmare
  .goto('https://beauto.com.ua' + url)
  .inject('js', 'vendor/bower/jquery/dist/jquery.min.js')
  .wait('#root .all-data .layout')
  .evaluate(function () {
    if ($('#root .all-data .layout .spoiler-link').length) {
        $('#root .all-data .layout .spoiler-link').trigger('click');
    }
    var items = [], imgs = [], links = [];
    $('#root .all-data .layout .all-gallery-container .gallery-container img').each(function() {
      imgs.push($(this).attr('src').replace('small', 'large'));
    });  
    $('#root .all-data .layout .characteristic-table td a').each(function() {
      links.push($(this).attr('href')); 
    });
    items.push(imgs);
    items.push(links);
    return JSON.stringify(items, null, 4);
  })
  .end()
  .then(function (result) {
    return console.log(result);
  })
  .catch(function (error) {
    console.error('Search failed:', error);
  });