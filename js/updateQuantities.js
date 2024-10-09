jQuery(document).ready(function ($) {


    const originalCount = parseInt($('#recette_pour').val()); // Utilise 1 par défaut si vide

    $('#recette_pour').on('input', function () {
        const newCount = parseInt(this.value);

        // Assurez-vous que originalCount est valide
        if (!isNaN(originalCount) && originalCount > 0) {
            const ingredients = $('.quantity');

            ingredients.each(function () {
                const originalQuantity = parseFloat($(this).data('original'));

                // Assurez-vous que originalQuantity est un nombre valide
                if (!isNaN(originalQuantity)) {
                    const adjustedQuantity = (originalQuantity / originalCount) * newCount;
                    // Vérifie si le nombre est entier
                    if (adjustedQuantity % 1 === 0) {
                        $(this).text(adjustedQuantity.toFixed(0)); // Pas de décimales
                    } else {
                        $(this).text(adjustedQuantity.toFixed(2)); // Deux décimales
                    }
                }
            });
        }
    });
});
