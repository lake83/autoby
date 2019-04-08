var Nightmare = require('nightmare'),
    nightmare = Nightmare({show: false})
    slug = process.argv[2];

nightmare
  .goto('https://beauto.com.ua/catalog/' + slug)
  .inject('js', 'vendor/bower/jquery/dist/jquery.min.js')
  .wait('#root .all-data .layout .items_list_row')
  .evaluate(slug => {
    if ($('#root .all-data .layout .items_list_row button[value=true]').length) {
        $('#root .all-data .layout .items_list_row button[value=true]').trigger('click');
    }
    var items = [];
    $('#root .all-data .layout .items_list_row .list___items a').each(function() {
      item = {};
      item.name = $(this).find('span > div > div > div').text();
      item.slug = $(this).attr('href').replace('/catalog/' + slug + '/', '');
      items.push(item);
    });
    return JSON.stringify(items, null, 4);
  }, slug)
  .end()
  .then(function (result) {
    return console.log(result);
  })
  .catch(function (error) {
    console.error('Search failed:', error);
  });