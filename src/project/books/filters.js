let applyBtn = document.getElementById('apply_filters');
let clearBtn = document.getElementById('clear_filters');

let cardsContainer = document.querySelector('.cards');
let cards = document.querySelectorAll('.card');

let form = document.querySelector('.filters form');

applyBtn.addEventListener('click', (event) => {
    event.preventDefault();
    applyFilters();
});

clearBtn.addEventListener('click', (event) => {
    event.preventDefault();
    clearFilters();
});

function applyFilters() {
    let filters = getFilters();

    cards.forEach(card => {
        let match = cardMatches(card, filters);
        card.classList.toggle('hidden', !match);
    });
}

function cardMatches(card, filters) {
    let title = card.dataset.title;
    let publisher = card.dataset.publisher;
    let format = card.dataset.format;

    let matchTitle =
        filters.title === "" || title.includes(filters.title);

    let matchPublisher =
        filters.publisher === "" || publisher === filters.publisher;

    let matchFormat =
        filters.format === "" || format.includes(filters.format);

    return matchTitle && matchPublisher && matchFormat;
}

function getFilters() {
    return {
        title: form.elements['title_filter'].value.trim().toLowerCase(),
        publisher: form.elements['publisher_filter'].value,
        format: form.elements['format_filter'].value
    };
}

function clearFilters() {
    form.reset();

    cards.forEach(card => {
        card.classList.remove('hidden');
    });
}