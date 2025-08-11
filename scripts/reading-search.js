//TO DO:
// reneame to reading-search
// only include on /reading pages
// search goodreads and prioritize
// make display of books pretty, match authors

window.addEventListener("load", () => {

  var dataInput = "";
  var fuse = "";
  const form = document.getElementById('reading-search-form');

  const options = {
      threshold: 0.225,
      includeScore: false,
      includeMatches: true,
      ignoreDiacritics: true,
      findAllMatches: true,
      keys: ['Title','Authors'],
    };

  function getBookRow(record){
    let dateRead = new Date(record.DateRead);
    let monthRead = dateRead.toLocaleString('default', { month: 'short' });
    return "" +
      "<div class=\"reading-search-row\" id=\"" + record.ISBN13 + "\">" +
        "<span class=\"book-title\">" +
          "<p>" +
            "<a href = \"/reading/titles/" + record.Title[0].toLowerCase() + "#" + record.ISBN13+ "\">" +
              record.Title +
            "</a>" +
            " -- " +
            "<a href = \"/reading/authors/" + record.Authors[0].toLowerCase() + "#" + record.Authors + "\">" +
              record.Authors +
            "</a>" +
          "</p>" +
        "</span>" +
      "</div>";

  };






  Papa.parse("/searchIndexes/reading.csv", {
  	download: true,
    header: true,
  	complete: function(results) {
      parsedInput = results.data;
      fuse = new Fuse(parsedInput, options);
  	}
  });



  // handle the form data - todo move logic to a function and double check async/promises
  form.addEventListener('submit', (event) => {
    event.preventDefault(); //prevent page reload

    let value = form.elements['reading-search-input'].value;

    let result = fuse.search(value);

    let results = "";
    for (var i = 0; i < result.length; i++){
      let bookRow = getBookRow(result[i].item);
      results = results + bookRow;
    }
    document.getElementById('reading-search-results').innerHTML = results;
  });

});
