

document.addEventListener('DOMContentLoaded', function() {
    initFavoriteButtons();
});


function initFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll('.favorite-btn-detail');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
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