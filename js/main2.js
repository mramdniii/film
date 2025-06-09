function searchMovie() {
    $('#movie-list').html('');

    $.ajax({
        url: 'https://www.omdbapi.com/',
        type: 'get',
        dataType: 'json',
        data: {
            'apikey' : '8782cf05',
            's' : $('#search-input').val()
        },
        success: function(result) {
            if ( result.Response == "True" ) {
                let movie = result.Search;

                $.each(movie, function(i, data) {
                    $('#movie-list').append(`
                        <div class="col-md-4 mb-3 d-flex">
                            <div class="card bg-dark text-white border-0 w-100">
                                <img src="`+ data.Poster +`" class="card-img-top" alt="...">
                                <div class="card-body d-flex flex-column justify-content-beetwen">
                                    <h5 class="card-title">`+ data.Title +`</h5>
                                    <h6 class="card-subtitle mb-2 text-white">`+ data.Year +`</h6>
                                    <a href="#" class="card-link see-detail" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="`+ data.imdbID +`">See Detail</a>
                                </div>
                            </div>
                        </div>
                    `)
                });

            $('#search-input').val('');

            } else {
                $('#movie-list').html(`
                    <div class="col center-both">
                        <h1 class="text-center text-white">`+ result.Error +`</h1>
                    </div>
                `)
            }
        }
    })
}

$('#search-form').on('submit', function (e) {
    e.preventDefault();
    searchMovie();
});


$('#movie-list').on('click', '.see-detail', function () {
    $.ajax({
        url: 'https://www.omdbapi.com/',
        type: 'get',
        dataType: 'json',
        data: {
            'apikey' : '8782cf05',
            'i' : $(this).data('id')
        },
        success: function (movie) {
            if ( movie.Response === "True" ) {
                $('.modal-body').html(`
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="`+ movie.Poster +`">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group">
                                    <li class="list-group-item"><h1 style="color: #141414">`+ movie.Title +`</h1></li>
                                    <li class="list-group-item">Released: `+ movie.Released +`</li>
                                    <li class="list-group-item">Genre: `+ movie.Genre +`</li>
                                    <li class="list-group-item">Director: `+ movie.Director +`</li>
                                    <li class="list-group-item">Actors: `+ movie.Actors +`</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                `)
            }
        }
    })
});

function loadDefaultMovies() {
    const defaultTitles = [
        'Harry Potter',
        'Insidious',
        'The Conjuring',
        'Frozen',
        'Joker',
        'Finding Nemo',
        'Money Heist',
        'Inception',
        'Avengers'
    ];

    $('#movie-list').html('');

    defaultTitles.forEach(function(title) {
    $.ajax({
        url: 'https://www.omdbapi.com/',
        type: 'get',
        dataType: 'json',
        data: {
            'apikey' : '8782cf05',
            't' : title,
        },
        success: function (movies) {
            if( movies.Response === 'True' ) {
                $('#movie-list').append(`
                    <div class="col-md-4 mb-3 d-flex">
                        <div class="card bg-dark text-white border-0 w-100">
                            <img src="`+ movies.Poster +`" class="card-img-top" alt="...">
                            <div class="card-body d-flex flex-column justify-content-beetwen">
                                <h5 class="card-title mb-3">`+ movies.Title +`</h5>
                                <h6 class="card-subtitle mb-2 text-white">`+ movies.Year +`</h6>
                                <a href="#" class="card-link see-detail" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="`+ movies.imdbID +`">See Detail</a>
                            </div>
                        </div>
                    </div>
                `);


            }
        }
    })
    })
}

$(document).ready(function () {
    loadDefaultMovies();
});

$('#home').on('click', function () {
    loadDefaultMovies();
});


function updateLanguageOption () {
    const select = document.querySelector('.language-select');
    if(!select) return;

    if (window.innerWidth <= 960) {
        select.options[1].text = "ENG";
        select.options[0].text = "IDN";
    } else {
        select.options[1].text = "English";
        select.options[0].text = "Bahasa Indonesia";
    }
}

window.addEventListener('DOMContentLoaded', updateLanguageOption);
window.addEventListener('resize', updateLanguageOption);