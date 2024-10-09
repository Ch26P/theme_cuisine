<!--liste course  -->
<<div id="create-shopping-list-container">
    <div id="required-ingredients">
        <h4>Ingrédients nécessaires pour vos recettes enregistrées</h4>
        <table>
            <thead>
                <tr>
                    <th>Ingrédient</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody id="required-ingredients-body"></tbody>
        </table>
    </div>

    <div id="additional-ingredients">
        <h4>Ingrédients ajoutés</h4>
        <table>
            <thead>
                <tr>
                    <th>Ingrédient</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody id="additional-ingredients-body"></tbody>
        </table>
        <select id="ingredient-selector"></select>
        <input type="number" id="ingredient-quantity" placeholder="Quantité">
        <select id="ingredient-unit">
            <option value="gr">gr</option>
            <option value="ml">ml</option>
            <!-- Ajoute d'autres unités si nécessaire -->
        </select>
        <button id="add-ingredient-button">Ajouter l'ingrédient</button>
    </div>
    <button id="validate-button">Valider la liste finale</button>
</div>