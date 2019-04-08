var Nightmare = require('nightmare'),
    nightmare = Nightmare({show: false})
    slug = process.argv[2];

nightmare
  .goto('https://beauto.com.ua/catalog/' + slug)
  .inject('js', 'vendor/bower/jquery/dist/jquery.min.js')
  .wait('#root .all-data .layout .list_row')
  .evaluate(function () {
    var items = [];
    $('#root .all-data .layout .list_row .generations_row_list_item').each(function() {
      item = {};
      item.name = $(this).find('.catalog-all-text-list__subtext').text();
      item.years = $(this).find('span').text();
      items.push(item);
    });
    return JSON.stringify(items, null, 4);
  })
  .end()
  .then(function (result) {
    return console.log(result);
  })
  .catch(function (error) {
    console.error('Search failed:', error);
  });