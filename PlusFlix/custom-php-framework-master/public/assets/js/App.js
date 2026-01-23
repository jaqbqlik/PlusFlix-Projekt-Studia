document.addEventListener('DOMContentLoaded', function () {
    initFavoriteButtons();
});

function initFavoriteButtons() {
    // bierzemy każdy przycisk, który ma data-fav-url
    const favoriteButtons = document.querySelectorAll('[data-fav-url]');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const url = this.getAttribute('data-fav-url');
            if (!url) return;

            // Idziemy do PHP, które doda/usuwa z ulubionych i zrobi redirect back
            window.location.href = url;
        });
    });
}
