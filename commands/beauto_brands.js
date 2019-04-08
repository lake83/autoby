var Nightmare = require('nightmare');
    nightmare = Nightmare({show: false});

nightmare
  .goto('https://beauto.com.ua/catalog')
  .inject('js', 'vendor/bower/jquery/dist/jquery.min.js')
  .wait('#root .all-data .layout .items_list_row')
  .click('.jss21 button[value=true]')
  .wait('.jss25')
  .evaluate(function () {
    var items = [];
    $('#root .all-data .layout .items_list_row .list___items a').each(function() {
      item = {};
      item.name = $(this).find('span > div > div > div').text();
      item.slug = $(this).attr('href').replace('/catalog/', '');
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
  
