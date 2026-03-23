let applyBtn = document.getElementById("apply_filters");
let clearBtn = document.getElementById("clear_filters");

let cards = document.getElementById("filters");

applyBtn.addEventListener('click', (event) => {
    event.preventDefault();
    clearFilters();
});


clearBtn.addEventListener('click', (event) => {});

function applyFilters(){
    let filters = getFilter();
    let matches = [];
    for ( let i - 0; i != cards.length; i++)
}

function getFilters(){
    const titleE1 = form.elements['title_filter'];
    const genreE1 = form.elements['genre_filter'];
    const platformE1 = form.elements['platform_filter'];
    const sortE1 = form.elements['sort_filter'];

    let titlFilter = (titleE1.value || ' ').trim().toLowerCase();
    let genreFilter = genreE1.value || '';
    let platformFilter = platformE1.value || '';
    let sortFilter = sortE1.value || 'title_asc';
}

return
    "titleFilter" : titleFilter;


function clearFilters(){
    console.log("clearing filters")
}