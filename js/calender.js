let selectedDates = []; // Tableau pour stocker les dates cochées
window.selectedDates = selectedDates; // Rendre accessible globalement

document.addEventListener('DOMContentLoaded', function () {
    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();
    let mealData = {}; // Pour stocker les repas planifiés avec ID
    ////////////////////////////////////////////////////////////////
    //  window.selectedDates = []; // Tableau pour stocker les dates cochées
    ///////////////////////////////////////////////////////////////////////////
    updateCalendar();




    // Utilisez les valeurs des éléments HTML pour pageTitle et pageId
    const pageTitle = document.getElementById('page-name-value').textContent.trim();
    const pageId = pageData.pageId;
    const ajaxurl = window.ajaxurl;
    const nonce = window.nonce;
    const userId = pageData.userId;

    function generateUniqueId() {
        return 'meal-' + Math.random().toString(36).substr(2, 9);
    }

    // Charger les repas lors du chargement de la page
    if (userId) {
        loadMeals();
    } else {
        updateCalendar(); // Affiche le calendrier vide pour les utilisateurs non connectés
    }

    function updateCalendar() {
        const calendarBody = document.getElementById('calendar-body');
        const currentMonthYear = document.getElementById('current-month-year');
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();

        let html = '';
        let day = 1;

        for (let row = 0; day <= daysInMonth; row++) {
            html += '<tr>';

            for (let col = 0; col < 7; col++) {
                if (row === 0 && col < firstDay) {
                    html += '<td class="calendar-day-cell empty"></td>';
                } else if (day <= daysInMonth) {
                    const date = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                    const dateMeals = mealData[date] || { breakfast: [], lunch: [], dinner: [] };

                    html += `
                        <td class="calendar-day-cell" data-date="${date}">
                            ${day}
                            <div class="meal-block breakfast">
                                ${dateMeals.breakfast.length > 0 ? dateMeals.breakfast.map(meal => `
                                    ${meal.name} pour ${meal.pers} pers
                                    <span class="delete-btn" data-date="${date}" data-meal="breakfast" data-id="${meal.id}" data-page_id="${meal.page_id}" data-pers="${meal.pers}">✖</span>
                                `).join('<br>') : 'Déjeuner'}
                            </div>
                            <div class="meal-block lunch">
                                ${dateMeals.lunch.length > 0 ? dateMeals.lunch.map(meal => `
                                    ${meal.name} pour ${meal.pers} pers
                                    <span class="delete-btn" data-date="${date}" data-meal="lunch" data-id="${meal.id}" data-page_id="${meal.page_id}" data-pers="${meal.pers}">✖</span>
                                `).join('<br>') : 'Repas du midi'}
                            </div>
                            <div class="meal-block dinner">
                                ${dateMeals.dinner.length > 0 ? dateMeals.dinner.map(meal => `
                                    ${meal.name} pour ${meal.pers} pers
                                    <span class="delete-btn" data-date="${date}" data-meal="dinner" data-id="${meal.id}" data-page_id="${meal.page_id}" data-pers="${meal.pers}">✖</span>
                                `).join('<br>') : 'Repas du soir'}
                            </div>
                            <div class="checkbox-container">
                                <input type="checkbox" class="select-day" id="select-${date}" value="${date}">
                                <label for="select-${date}" class="select-day-label"></label>
                                <span class="info-message">Sélectionner ce jour pour votre liste de courses</span>
                            </div>
                        </td>`;
                    day++;
                } else {
                    html += '<td class="calendar-day-cell empty"></td>';
                }
            }
            html += '</tr>';
        }

        calendarBody.innerHTML = html;
        currentMonthYear.textContent = `${new Date(currentYear, currentMonth).toLocaleString('fr-FR', { month: 'long' })} ${currentYear}`;
        //////////////////////////////////////////////////////////////////////
        // Ajouter des écouteurs d'événements pour les checkboxes
        addCheckboxListeners();

        // Cochez automatiquement les dates déjà présentes dans selectedDates
        checkSelectedDates();
        /////////////////////////////////////////////////////////
    }
    //////////////////////////////////////////////////////////
    // Ajoute des écouteurs sur toutes les checkboxes pour gérer les dates cochées/décochées
    function addCheckboxListeners() {
        const checkboxes = document.querySelectorAll('.select-day');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const date = this.value;
                const mealBlocks = this.closest('td').querySelectorAll('.meal-block'); // Récupérer les div meal-block

                // Vérifier si au moins une span existe dans les meal-blocks
                const hasMeals = Array.from(mealBlocks).some(block => block.querySelector('span'));

                if (this.checked) {
                    if (hasMeals) {
                        // Ajouter la date cochée au tableau
                        selectedDates.push(date);
                    } else {
                        // Décocher la case si aucune recette n'est disponible
                        this.checked = false;
                        alert("Vous ne pouvez pas sélectionner ce jour car aucune recette n'est programmée à cette date.");
                    }
                } else {
                    // Retirer la date décochée du tableau
                    selectedDates = selectedDates.filter(d => d !== date);
                }
                // Afficher le tableau dans la console
                console.log('Dates sélectionnées :', selectedDates);
            });
        });
    }

    // Cochez automatiquement les dates déjà présentes dans selectedDates
    function checkSelectedDates() {
        selectedDates.forEach(date => {
            const checkbox = document.getElementById(`select-${date}`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }

    ///////////////////////////////////////////////////////





    document.getElementById('prev-month').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });

    document.getElementById('next-month').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });

    function displayPageInfo() {
        document.getElementById('page-name-value').textContent = pageTitle || 'Non disponible';
    }

    function loadMeals() {
        fetch(pageData.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'get_meals',
                nonce: pageData.nonce,
                user_id: pageData.userId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mealData = {}; // Réinitialiser mealData avant de charger de nouvelles données
                    for (const [date, mealTypes] of Object.entries(data.data)) {
                        for (const [mealType, mealArray] of Object.entries(mealTypes)) {
                            mealArray.forEach(meal => {
                                if (!mealData[date]) mealData[date] = { breakfast: [], lunch: [], dinner: [] };
                                mealData[date][mealType].push(meal);
                            });
                        }
                    }
                    updateCalendar(); // Met à jour le calendrier avec les repas chargés
                } else {
                    console.error('Erreur lors du chargement des repas:', data.data.message || 'Erreur inconnue.');
                    updateCalendar();
                }
            })
            .catch(error => {
                console.error('Erreur:', error)
            });
    }

    document.getElementById('add-meal').addEventListener('click', () => {
        const date = document.getElementById('meal-date').value;
        const mealType = document.getElementById('meal-type').value;
        const mealName = document.getElementById('meal-name').value;
        const mealPers = document.getElementById('meal-pers').value;

        if (date && mealType && mealName) {
            if (!userId) {
                alert('Connectez-vous pour utiliser le calendrier pour planifier vos repas.');
                return;
            }
            fetch(pageData.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'save_meal',
                    nonce: pageData.nonce,
                    userId: pageData.userId,
                    pageId: pageId,
                    mealDate: date,
                    mealType: mealType,
                    mealName: mealName,
                    numberOfPeople: mealPers,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadMeals(); // Recharger les repas après ajout
                    } else {
                        alert(data.data || 'Erreur lors de l\'ajout du repas.');
                    }
                })
                .catch(error => console.error('Erreur:', error));
        } else {
            alert('Veuillez remplir tous les champs.');
        }
    });

    function handleDeleteMeal(event) {
        const target = event.target;
        if (target.classList.contains('delete-btn')) {
            const mealId = target.getAttribute('data-id');
            if (confirm('Êtes-vous sûr de vouloir supprimer ce repas ?')) {
                deleteMeal(mealId);
            }
        }
    }

    document.getElementById('calendar-body').addEventListener('click', handleDeleteMeal);

    function deleteMeal(mealId) {
        fetch(pageData.ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                action: 'delete_meal',
                nonce: pageData.nonce,
                mealId: mealId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Repas supprimé avec succès.');
                    loadMeals(); // Recharger les repas après suppression
                } else {
                    alert('Erreur lors de la suppression du repas.');
                }
            })
            .catch(error => console.error('Erreur:', error));
    }
});
//////////////////////////////////////////////////////////////*ok jusque la *//////////////////////////////////////////////////// 










