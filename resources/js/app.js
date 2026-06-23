
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Live AJAX Search Logic
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearchInput');
    const productGridContainer = document.getElementById('productGridContainer');

    if (searchInput && productGridContainer) {
        let debounceTimer;

        searchInput.addEventListener('keyup', function(e) {
            clearTimeout(debounceTimer);
            
            // Wacht 300ms nadat de gebruiker stopt met typen (Debouncing)
            debounceTimer = setTimeout(() => {
                const query = e.target.value;
                const url = new URL(window.location.href);
                
                if (query.length > 0) {
                    url.searchParams.set('search', query);
                    // Reset pagination als je aan een nieuwe zoekopdracht begint!
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.delete('search');
                }

                // Update de URL balk in de browser (zonder te herladen)
                window.history.pushState({}, '', url);

                // Visuele feedback (maak het grid even iets transparanter)
                productGridContainer.style.opacity = '0.5';

                // Haal de nieuwe data op
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Vertel Laravel dat dit een AJAX request is
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Vervang de oude producten door de nieuwe HTML
                    productGridContainer.innerHTML = html;
                    productGridContainer.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    productGridContainer.style.opacity = '1';
                });
            }, 300);
        });
    }
});

// Dynamische Prijs Update (Product Detail Pagina)
document.addEventListener('DOMContentLoaded', function() {
    const variantSelect = document.getElementById('variant');
    const displayPrice = document.getElementById('display-price');
    
    if (variantSelect && displayPrice) {
        // Bewaar de originele HTML van de prijs
        const basePriceHtml = displayPrice.innerHTML;
        
        variantSelect.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                const newPrice = parseFloat(selectedOption.getAttribute('data-price')).toFixed(2).replace('.', ',');
                displayPrice.innerHTML = newPrice;
            } else {
                displayPrice.innerHTML = basePriceHtml;
            }
        });
    }
});
