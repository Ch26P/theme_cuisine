<div id="calendar-overlay"></div>
<div id="calendar-container">
    <button id="close-calendar">✖</button>
    <div id="calendar-header">
        <button id="prev-month">Précédent</button>
        <span id="current-month-year"></span>
        <button id="next-month">Suivant</button>
    </div>
    <table id="calendar">
        <thead>
            <tr>
                <th class="calendar-day header">Dim</th>
                <th class="calendar-day header">Lun</th>
                <th class="calendar-day header">Mar</th>
                <th class="calendar-day header">Mer</th>
                <th class="calendar-day header">Jeu</th>
                <th class="calendar-day header">Ven</th>
                <th class="calendar-day header">Sam</th>
            </tr>
        </thead>
        <tbody id="calendar-body">
            <!-- Le calendrier sera généré ici avec JavaScript -->
        </tbody>
    </table>
    <!-- Bouton pour créer la liste de courses -->

    <button type="button" id="create-list-button">Créer ma liste de courses</button>


</div>
<!---------------------------------------     shopping list    --------------------------------------->
<div id="create-shopping-list-container">

    <div id=essai-shopping-list></div>
    <div id="required-ingredients">
        <h3>Ingrédients nécessaires pour vos recettes enregistrées</h3>
        <table>
            <thead>
                <tr>
                    <th>Choix</th>
                    <th>Ingrédient</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                    <th>Note</th> <!-- Nouvelle colonne pour les notes -->
                </tr>
            </thead>
            <tbody id="necessary-ingredient-table-body">
                <!-- Les ingrédients seront remplis par AJAX -->
            </tbody>
        </table>
    </div>
    <div id="additional-ingredients">
    <h3>finaliser votre liste de course</h3>
                <!--------------------------------------------------------------------------------------------->
        <select id="ingredient-select">
            <option value="">Sélectionner un ingrédient</option>
            <?php
            // Récupérer les ingrédients de la taxonomie pour pré-remplir le select
            $ingredients = get_terms(array('taxonomy' => 'taxo-ingredient', 'hide_empty' => false));
            foreach ($ingredients as $ingredient) {
                echo '<option value="' . esc_attr($ingredient->name) . '">' . esc_html($ingredient->name) . '</option>';
            }
            ?>
        </select>
        <input type="number" id="ingredient-quantity" placeholder="Quantité" min="0.1" step="0.1"  required>
        <!--  <input type="text" id="ingredient-unit" placeholder="Unité"> -->
        <select id="ingredient-unit-select">
            <option value="">Sélectionner une unité de mesure</option>
            <?php
            // Récupérer les unités de mesure de la taxonomie pour pré-remplir le select
            $units = get_terms(array('taxonomy' => 'taxo-unite-mesure', 'hide_empty' => false));
            foreach ($units as $unit) {
                echo '<option value="' . esc_attr($unit->name) . '">' . esc_html($unit->name) . '</option>';
            }
            ?>
        </select>
        <button id="add-selected-ingredient">Ajouter sélectionné</button></br>

        <!---------------------------------------------------------------------------------------->

        <input type="text" id="manual-ingredient" placeholder="Ajouter un ingrédient manuellement">
        <input type="number" id="manual-quantity" placeholder="Quantité" min="0.1" step="0.1"  required>
        <!--  <input type="text" id="manual-unit" placeholder="Unité"> -->
        <select id="ingredient-unit-select-manual">
            <option value="">Sélectionner une unité</option>
            <?php
            // Récupérer les unités de mesure depuis la taxonomie ou autre source
            $units = get_terms(array('taxonomy' => 'taxo-unite-mesure', 'hide_empty' => false));
            foreach ($units as $unit) {
                echo '<option value="' . esc_attr($unit->name) . '">' . esc_html($unit->name) . '</option>';
            }
            ?>
        </select>
        <button id="add-manual-ingredient">Ajouter</button>
    </div>

    <!------------------------------------------------------------------------------------------------>
       <h4>Votre liste</h4>
        <table>
            <thead>
                <tr>
                    <th>Supprimer</th>
                    <th>Ingrédient</th>
                    <th>Quantité</th>
                    <th>Quantité pour recettes </th>
                    <th>Total Quantité</th>
                    <th>Unité</th>
                    <th>Note</th> <!-- Nouvelle colonne pour les notes -->
                    
                </tr>
            </thead>
            <tbody id="additional-ingredient-table-body">
                <!-- Les ingrédients ajoutés manuellement seront remplis ici -->
            </tbody>
        </table>
        <div>
        <button id="validate-list-button">Valider la liste finale</button>
    </div>
<!----------------------------------------------------------------------------------------------------->

    <!-- Formulaire pour ajouter un repas -->
    <div id="meal-form">
        <h2>Planifiez vos Repas</h2>
        <form>
            <label for="meal-date">Date :</label>
            <input type="date" id="meal-date" required>
            <label for="meal-type">Type de repas :</label>
            <select id="meal-type" required>
                <option value="breakfast">Déjeuner</option>
                <option value="lunch">Repas du midi</option>
                <option value="dinner">Dîner</option>
            </select>
            <label for="meal-name">Nom de la recette :</label>
            <input type="text" id="meal-name" required value="<?php echo get_the_title(); ?>">
            <label for="meal-pers">Nombre de personnes :</label>
            <input type="number" id="meal-pers" required value="4"><!--la valeur sera le nbres de persoone  nbre est juste un exemple cela sera remplie en js plus tard-->
            <button type="button" id="add-meal">Ajouter ce repas</button>
        </form>
        <button type="button" id="view-calendar">Voir mon calendrier</button>
    </div>

    <!-- Informations sur la page -->
    <div id="page-info">
        <h2>Informations sur la page</h2>
        <p>Nom de la page : <span id="page-name-value"><?php echo get_the_title(); ?></span></p>
        <p>ID de la page : <span id="page-id-value"><?php echo get_the_ID(); ?></span></p>
        <p>ID utilisateur :<span><?php echo get_current_user_id(); ?></span>
    </div>