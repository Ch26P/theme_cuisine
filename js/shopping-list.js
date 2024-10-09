// Fonction pour décoder les entités HTML
function decodeHTMLEntities(text) {
    const textArea = document.createElement('textarea');
    textArea.innerHTML = text;
    return textArea.value;
}

// Fonction pour encoder les entités HTML et éviter les failles XSS
function encodeHTMLEntities(text) {

    const textArea = document.createElement('textarea');
    div.textContent = text;
    return textArea.value;

}


let additionalIngredientTableBody;


// Fonction pour vérifier si l'ingrédient existe déjà dans le tableau
function ingredientExistsInTable(ingredientName) {
    const rows = additionalIngredientTableBody.querySelectorAll('tr');
    for (const row of rows) {
        if (row.cells[1].textContent === ingredientName) {
            return true; // L'ingrédient existe déjà
        }
    }
    return false; // L'ingrédient n'existe pas
}


// Fonction pour vérifier si un ingrédient a déjà été ajouté manuellement
function checkManualIngredient(ingredientName) {
    const rows = additionalIngredientTableBody.querySelectorAll('tr');
    for (const row of rows) {
        if (row.cells[1].textContent === ingredientName) {
            return row; // Retourner la ligne existante
        }
    }
    return null; // L'ingrédient n'existe pas
}


// Fonction pour mettre à jour la colonne 'Total Quantité'
function updateTotalQuantity() {
    const additionalTableBody = document.getElementById('additional-ingredient-table-body');
    const rows = additionalTableBody.querySelectorAll('tr');

    rows.forEach(row => {
        const quantityInput = row.querySelector('.quantity-input'); // Assurez-vous que ce sélecteur correspond à vos inputs
        const recipeQuantityCell = row.querySelector('.recipe-quantity'); // Idem pour la cellule de quantité de recette
        const totalQuantityCell = row.querySelector('.total-quantity'); // Idem pour la cellule de total

        const quantity = parseFloat(quantityInput.value) || 0; // Récupère la valeur entrée ou 0
        const recipeQuantity = parseFloat(recipeQuantityCell.textContent) || 0; // Récupère la quantité de recette ou 0

        const totalQuantity = quantity + recipeQuantity; // Calcul du total
        totalQuantityCell.textContent = totalQuantity.toFixed(2); // Affichage avec deux décimales
    });
}



//  fonction pour récupérer la parent et le grandparent de l'ingrédient
function findParentAndGrandparent(name) {
    for (const ingredient of hierarchieIngredient) {
        if (ingredient.name === name) {
            return {
                parent: ingredient.parent,
                grandparent: ingredient.grandparent
            };
        }
    }
    return null; // Si le nom n'est pas trouvé
}



document.addEventListener('DOMContentLoaded', function () {
    const createListButton = document.getElementById('create-list-button');
    const shoppingListContainer = document.getElementById('create-shopping-list-container');
    additionalIngredientTableBody = document.getElementById('additional-ingredient-table-body');



    const limitInputLength = (inputElement) => {
        inputElement.addEventListener('input', () => {
            // Supprime tous les caractères non numériques (sauf les décimales et les chiffres)
            inputElement.value = inputElement.value.replace(/[^0-9.]/g, '');

            if (inputElement.value.length > 4) {
                inputElement.value = inputElement.value.slice(0, 4); // Limiter à 4 caractères
            }
        });
    };

    const quantityInputs = [
        document.getElementById('ingredient-quantity'),
        document.getElementById('manual-quantity'),
        document.getElementById('meal-pers'),
    ];

    quantityInputs.forEach(input => {
        if (input) {
            limitInputLength(input);
        }
    });

    const manualIngredientInput = document.getElementById('manual-ingredient');

    if (manualIngredientInput) {
        manualIngredientInput.addEventListener('input', () => {
            if (manualIngredientInput.value.length > 25) {
                alert("La limite de 25 caractères a été atteinte !");
            }
        });
    }



    if (createListButton) {
        createListButton.addEventListener('click', function () {


            // Appel AJAX pour récupérer la taxonomie 'taxo-ingredient'
            fetch(pageData.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'get_taxo_ingredients'
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Stocker les taxonomies reçues dans une variable global
                        hierarchieIngredient = data.data;
                        console.log('Taxonomies récupérées :', hierarchieIngredient);

                        // Tu peux maintenant utiliser la constante taxonomies ici
                    } else {
                        console.error('Erreur lors de la récupération des taxonomies.');
                    }
                })
                .catch(error => {
                    console.error('Erreur AJAX lors de la récupération des taxonomies.', error);
                });




            const confirmed = window.confirm("Avez-vous bien sélectionné tous les jours dont les repas seront inclus pour faire votre liste de courses ?");

            if (confirmed) {
                // Réinitialiser le contenu des ingrédients nécessaires
                const necessaryTbody = document.getElementById('necessary-ingredient-table-body');
                necessaryTbody.innerHTML = ''; // Effacer les anciennes lignes

                /*  const Checkeddates = Array.from(document.querySelectorAll('.select-day:checked'))
                       .map(checkbox => checkbox.value);
   */
            //   let Checkeddates = window.selectedDates; // Récupérer la variable globale
 // Toujours récupérer les dates sélectionnées au moment du clic
 const Checkeddates = [...window.selectedDates]; // Créer une copie



                console.log("Checkeddates:",Checkeddates);
                if (Checkeddates.length === 0) {
                    necessaryTbody.innerHTML = '<tr><td colspan="4">Aucune date sélectionnée.</td></tr>';
                    return;
                }

                // Requête AJAX pour récupérer les repas
                fetch(pageData.ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'get_meals',
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const recipes = [];
                            Checkeddates.forEach(date => {
                                const mealsForDate = data.data[date];
                                for (const [mealType, meals] of Object.entries(mealsForDate)) {
                                    if (Array.isArray(meals)) {
                                        meals.forEach(meal => {
                                            recipes.push({
                                                id: meal.page_id,
                                                number_of_people: meal.pers
                                            });
                                        });
                                    }
                                }
                            });

                            // Envoyer les IDs et le nombre de personnes à la fonction PHP
                            return fetch(pageData.ajaxurl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({
                                    action: 'get_ingredients_for_recipes',
                                    recipe_ids: JSON.stringify(recipes)
                                })
                            });
                        } else {
                            necessaryTbody.innerHTML = '<tr><td colspan="4">Erreur lors de la récupération des repas.</td></tr>';
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const ingredientMap = {};

                            // Regroupement des ingrédients
                            data.data.forEach(recipe => {
                                recipe.ingredients.forEach(ingredient => {
                                    const name = decodeHTMLEntities(ingredient.name);
                                    let quantity = ingredient.quantity;
                                    let unit = ingredient.unit;
                                    /**/
                                    // Traitement des unités de mesure spécifiques
                                    if (unit === "pincée") {
                                        unit = "g"; // Remplace "pincée" par "g"
                                        quantity *= 0.5; // Multiplie la quantité par 0.5
                                    }


                                    if (unit === "Cuillère(s) a café") {
                                        console.log("Cuillère(s) a café");

                                        // Calcul de la quantité
                                        quantity *= 5; // Multiplie la quantité par 5 pour Cuillère à café

                                        let parent, grandparent;

                                        // Utilisation de la fonction findParentAndGrandparent  pour recuperer le parent et grand parent de l ingredients 
                                        const result = findParentAndGrandparent(name);
                                        if (result) {
                                            console.log('Parent:', result.parent);
                                            parent = result.parent;
                                            console.log('Grand-parent:', result.grandparent);
                                            grandparent = result.grandparent;
                                        } else {
                                            console.log('Ingrédient non trouvé.');
                                        }


                                        // Vérification des conditions pour l'unité
                                        if (grandparent === "Boissons" || grandparent === "Huiles et Vinaigres" ||
                                            parent === "Laits" || parent === "Arômes et extraits liquides" ||
                                            name.includes("liquide")) {
                                            unit = "ml"; // Si l'une des conditions est remplie, l'unité sera "ml"
                                        } else {
                                            unit = "g"; // Sinon, l'unité sera "g"
                                        }

                                    }
                                    if (unit === "Cuillère(s) a soupe") {
                                        console.log("Cuillère(s) a soupe");

                                        // Calcul de la quantité
                                        quantity *= 15; // Multiplie la quantité par 15 pour Cuillère à soupe

                                        let parent, grandparent;


                                        // Utilisation
                                        const result = findParentAndGrandparent(name);
                                        if (result) {
                                            console.log('Parent:', result.parent);
                                            parent = result.parent;
                                            console.log('Grand-parent:', result.grandparent);
                                            grandparent = result.grandparent;
                                        } else {
                                            console.log('Ingrédient non trouvé.');
                                        }

                                        // Vérification des conditions pour l'unité
                                        if (grandparent === "Boissons" || grandparent === "Huiles et Vinaigres" ||
                                            parent === "Laits" || parent === "Arômes et extraits liquides" ||
                                            name.includes("liquide")) {
                                            unit = "ml"; // Si l'une des conditions est remplie, l'unité sera "ml"
                                        } else {
                                            unit = "g"; // Sinon, l'unité sera "g"
                                        }
                                    }

                                    // Normalisation et addition des ingrédients
                                    if (unit === "g" || unit === "kg") {
                                        // Convertir kg en g
                                        if (unit === "kg") {
                                            quantity *= 1000; // Conversion en grammes
                                            unit = "g"; // Mettre à jour l'unité
                                        }
                                    }

                                    if (unit === "ml" || unit === "cl" || unit === "dl" || unit === "Litre(s)") {
                                        // Convertir les autres unités en ml
                                        if (unit === "cl") {
                                            quantity *= 10; // cl à ml
                                            unit = "ml";
                                        } else if (unit === "dl") {
                                            quantity *= 100; // dl à ml
                                            unit = "ml";
                                        } else if (unit === "Litre(s)") {
                                            quantity *= 1000; // litre à ml
                                            unit = "ml";
                                        }
                                    }


                                    // Accumulation des quantités d'ingrédients
                                    if (!ingredientMap[name]) {
                                        ingredientMap[name] = { total: 0, unit: unit };
                                    }
                                    ingredientMap[name].total += quantity;
                                });
                            });

                            // Traitement des gousses d'ail après avoir fait la somme totale
                            if (ingredientMap["ail"]) {
                                const totalGarlicCloves = ingredientMap["ail"].total; // Total des gousses d'ail

                                // Conversion des gousses en nombre d'ails
                                const garlicHeads = Math.ceil(totalGarlicCloves / 10); // Conversion en nombre d'ails

                                // Mise à jour de l'unité et du total dans le tableau
                                ingredientMap["ail"] = {
                                    total: garlicHeads,
                                    unit: "– (Pièce(s), unité(s), ….)" // Unité convertie
                                };

                                alert(`Vous avez ${totalGarlicCloves} gousse(s), cela équivaut à ${garlicHeads} ail(s).`);
                            }


                            // Conversion finale des totaux
                            for (const [name, { total, unit }] of Object.entries(ingredientMap)) {
                                if (unit === "g" && total >= 1000) {
                                    ingredientMap[name].total = total / 1000; // Convertir en kg
                                    ingredientMap[name].unit = "kg"; // Changer l'unité
                                } else if (unit === "ml" && total >= 1000) {
                                    ingredientMap[name].total = total / 1000; // Convertir en litres
                                    ingredientMap[name].unit = "Litre(s)"; // Changer l'unité
                                }
                            }


                            // Remplissage du tableau des ingrédients nécessaires
                            for (const [name, { total, unit }] of Object.entries(ingredientMap)) {

                                const row = document.createElement('tr');
                                row.innerHTML = `
                    <td><input type="checkbox" class="ingredient-checkbox"></td>
                    <td>${name}</td>
                    <td>${total}</td>
                    <td>${unit}</td>
                    <td><input type="text" placeholder="Votre note" class="ingredient-note"></td>
                `;
                                necessaryTbody.appendChild(row);
                            }

                        } else {
                            necessaryTbody.innerHTML = '<tr><td colspan="4">Erreur lors de la récupération des ingrédients.</td></tr>';
                        }
                    })

                    .catch(error => {
                        console.error('Erreur:', error);
                        necessaryTbody.innerHTML = '<tr><td colspan="4">Erreur de connexion au serveur.</td></tr>';
                    });
            } else {
                console.log('Action annulée par l\'utilisateur.');
            }
        });
    }

    // Gestion des ingrédients ajoutés manuellement
    const addSelectedIngredientButton = document.getElementById('add-selected-ingredient');
    const addManualIngredientButton = document.getElementById('add-manual-ingredient');
    // const additionalIngredientTableBody = document.getElementById('additional-ingredient-table-body');

    if (addSelectedIngredientButton) {
        addSelectedIngredientButton.addEventListener('click', function () {
            const ingredientSelect = document.getElementById('ingredient-select');
            const ingredientUnit = document.getElementById('ingredient-unit-select');
            const ingredientQuantity = document.getElementById('ingredient-quantity');

            const selectedIngredient = ingredientSelect.options[ingredientSelect.selectedIndex];
            const unit = ingredientUnit.options[ingredientUnit.selectedIndex];
            const quantity = ingredientQuantity.value;

            // Vérification que tous les champs sont remplis
            if (!selectedIngredient.value || !quantity || !unit.value) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            // Vérification que la quantité est un nombre positif
            if (!/^\d+(\.\d{1,2})?$/.test(quantity) || parseFloat(quantity) <= 0) {
                alert("La quantité doit être un nombre positif.");
                return;
            }

            // Vérification si l'ingrédient existe déjà dans le tableau
            if (ingredientExistsInTable(selectedIngredient.textContent)) {
                alert("Cet ingrédient est déjà dans la liste des ingrédients ajoutés.Ajouter une quantité suplémentaire dans la colonne quantité");
                return;
            }

            if (selectedIngredient/*.value */ && quantity) {
                const row = document.createElement('tr');
                row.classList.add('manual-ingredient'); // Ajoute cette ligne lors de l'ajout d'un ingrédient manuellement
                row.innerHTML = `
                   <td><button class="remove-ingredient">✖</button></td>
                   <td>${selectedIngredient.textContent}</td>
                   <td><input type="number" class="quantity-input" placeholder="Ajouter quantité" value="${quantity}"></td>
                   <td  class="recipe-quantity">0</td>
                   <td class="total-quantity">0</td>
                   <td>${unit.textContent}</td>
                   <td><input type="text" placeholder="Votre note" class="ingredient-note"></td>
               `;
                additionalIngredientTableBody.appendChild(row);
                updateTotalQuantity(row);
                // Réinitialiser les champs
                ingredientSelect.selectedIndex = 0;
                ingredientQuantity.value = '';
                ingredientUnit.selectedIndex = 0;

                // Écouteur d'événements pour les inputs de quantité
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('input', updateTotalQuantity);
                });
            }
        });
    }

    if (addManualIngredientButton) {
        addManualIngredientButton.addEventListener('click', function () {
            const manualIngredient = document.getElementById('manual-ingredient');
            const manualQuantity = document.getElementById('manual-quantity');
            const manualUnit = document.getElementById('ingredient-unit-select-manual');

            const ingredientName = manualIngredient.value;
            const quantity = manualQuantity.value;
            const unit = manualUnit.value;

            // Vérification que tous les champs sont remplis
            if (!ingredientName || !quantity || !unit) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            // Vérification que le nom de l'ingrédient est une chaîne valide (lettres uniquement)
            if (!/^[a-zA-Z\s]+$/.test(ingredientName)) {
                alert("Le nom de l'ingrédient n'est pas valide. Seules les lettres et espaces sont autorisés.");
                return;
            }

            // Vérification que la quantité est un nombre positif
            if (!/^\d+(\.\d{1,2})?$/.test(quantity) || parseFloat(quantity) <= 0) {
                alert("La quantité doit être un nombre positif.");
                return;
            }


            //   if (ingredientName && quantity && unit) {
            const row = document.createElement('tr');
            row.classList.add('manual-ingredient'); // Ajoute cette ligne lors de l'ajout d'un ingrédient manuellement
            row.innerHTML = `
                   <td><button class="remove-ingredient">✖</button></td>
                   <td>${ingredientName}</td>
                   <td><input type="number" class="quantity-input" placeholder="Ajouter quantité" value="${quantity}"></td>
                   <td class="recipe-quantity">0</td>
                   <td class="total-quantity">0</td>
                   <td>${unit}</td>
                   <td><input type="text" placeholder="Votre note" class="ingredient-note"></td>
               `;
            additionalIngredientTableBody.appendChild(row);
            updateTotalQuantity(row);
            // Réinitialiser les champs
            manualIngredient.value = '';
            manualQuantity.value = '';
            manualUnit.value = '';

            // Écouteur d'événements pour les inputs de quantité
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', updateTotalQuantity);
            });

        });

    }

});

// Gestion des cases à cocher
document.querySelector('#required-ingredients').addEventListener('change', function (event) {
    if (event.target.classList.contains('ingredient-checkbox')) {
        const row = event.target.closest('tr');
        const ingredientName = row.cells[1].textContent; // Nom de l'ingrédient
        const quantityForRecipes = row.cells[2].textContent; // Quantité pour recettes
        const unit = row.cells[3].textContent; // Unité



        if (event.target.checked) {


            // Vérification si l'ingrédient a déjà été ajouté manuellement
            const existingRow = checkManualIngredient(ingredientName);

            if (existingRow) {
                // Remplacer la ligne existante par celle du tableau 1
                existingRow.cells[2].querySelector('input').value = ''; // Réinitialiser la quantité
                existingRow.cells[3].textContent = quantityForRecipes; // Mettre à jour la quantité pour recettes
                existingRow.cells[5].textContent = unit; // Mettre à jour l'unité
                alert(`L'ingrédient ${ingredientName} a été mis à jour avec les données de la recette.`);
                return; // Ne pas ajouter à nouveau
            }


            // Créer une nouvelle ligne dans le tableau des ingrédients ajoutés manuellement
            const newRow = document.createElement('tr');

            newRow.classList.add('meal_ingredient'); // Ajoute la classe ici
            newRow.innerHTML = `
                <td><button class="remove-ingredient">✖</button></td>
                <td>${ingredientName}</td>
                <td><input type="number" class="quantity-input" placeholder="Ajouter quantité"></td>
                <td class="recipe-quantity">${quantityForRecipes}</td>
                <td class="total-quantity">0</td>
                <td>${unit}</td>
                <td><input type="text" placeholder="Votre note" class="ingredient-note"></td>
            `;
            additionalIngredientTableBody.appendChild(newRow);
            updateTotalQuantity(newRow);
            row.classList.add('ingredient-barré');

            // Écouteur d'événements pour les inputs de quantité
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', updateTotalQuantity);
            });
        } else {

            // Optionnel : retirer l'ingrédient du tableau des ingrédients ajoutés manuellement si la case est décochée
            const rows = additionalIngredientTableBody.querySelectorAll('tr');
            rows.forEach(addedRow => {
                if (addedRow.cells[1].textContent === ingredientName) {
                    additionalIngredientTableBody.removeChild(addedRow);
                }
            });

            row.classList.remove('ingredient-barré');
        }
    }

    // Écouteur d'événements pour les inputs de quantité
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', updateTotalQuantity);
    });


});
// Gestion de suppression des ligne ajouter au tableau
document.querySelector('#additional-ingredient-table-body').addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-ingredient')) {
        // Trouve la ligne parente à supprimer
        const row = event.target.closest('tr');
        if (row) {
            const ingredientName = row.cells[1].textContent; // Récupérer le nom de l'ingrédient

            // Vérifier si l'ingrédient provient du tableau 1
            if (!row.classList.contains('manual-ingredient')) { // Supposons que 'manual-ingredient' est la classe pour les ingrédients ajoutés manuellement
                // Trouver la case à cocher correspondante dans le tableau 1
                const checkboxes = document.querySelectorAll('#required-ingredients .ingredient-checkbox');
                checkboxes.forEach(checkbox => {
                    const parentRow = checkbox.closest('tr');
                    const rowIngredientName = parentRow.cells[1].textContent; // Nom de l'ingrédient dans le tableau 1

                    if (rowIngredientName === ingredientName) {
                        checkbox.checked = false; // Décoche la case correspondante
                        parentRow.classList.remove('ingredient-barré'); // Supprime la classe 'ingredient-barré'
                    }
                });
            }

            // Supprime la ligne de la table
            row.remove();
        }
    }





});








