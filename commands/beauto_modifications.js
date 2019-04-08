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
      var item = {}, mods = [];
      item.name = $(this).find('.catalog-all-text-list__subtext').text();
      item.years = $(this).find('span').text();
      $(this).find('.catalog-bodies-list div a').each(function() {
        var _mod = {};
        _mod.link = $(this).attr('href');
        _mod.mod = $(this).find('div span').text();
        mods.push(_mod);
      });
      item.mods = mods;
      items.push(item);
    });
    return items;
  })
  .end()
  .then(function (result) {
    return console.log(JSON.stringify(result, null, 4));
  })
  .catch(function (error) {
    console.error('Search failed:', error);
  });