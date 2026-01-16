
// +++ KM1 funkcje do przycisku ulubione +++ //
document.addEventListener('DOMContentLoaded', function() {
    initFavoriteButtons();
});


function initFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll('.favorite-btn-detail');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            toggleFavorite(this);
        });
    });
}

function toggleFavorite(button) {
    if (button.classList.contains('active')) {
        button.classList.remove('active');
        button.innerHTML = '♡';
    } else {
        button.classList.add('active');
        button.innerHTML = '♥';
    }
}
// +++ Koniec +++ //