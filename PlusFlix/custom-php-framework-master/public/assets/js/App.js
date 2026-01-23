document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.smoll-fav-btn').forEach(button => {

        button.addEventListener('click', async function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productionId = this.dataset.productionId;
            if (!productionId) return;

            try {
                const response = await fetch(
                    `/index.php?action=favorites-toggle-ajax&id=${productionId}`,
                    {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                const data = await response.json();

                if (data.success) {
                    this.classList.toggle('active', data.favorite);
                    this.innerHTML = data.favorite ? '♥' : '♡';
                }

            } catch (err) {
                console.error('Favorite AJAX error:', err);
            }
        });

    });

});
