<div id="groupe ingredient">
    <?php
    $list_champs = get_fields();
    if ($list_champs !== false) : ?>

        <!-- Champ pour le nombre de personnes -->
        <?php foreach ($list_champs as $name => $value) : ?>
            <?php if ($name === "recette_pour") : ?>
                <label for="recette_pour">Nombre de personnes :</label>
                <input type="number" id="recette_pour" name="recette_pour" min="1" value="<?php echo esc_attr($value); ?>" required />
            <?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($list_champs as $name => $value) : ?>
            <?php if ($name === "nbresetapes") : ?>
                <?php foreach ($value as $name2 => $value2) : ?>
                    <?php
                    // Vérifie si le nom de l'étape existe
                    $stepNameField = "nom_de_letape_" . substr($name2, -1);
                    if (isset($value2[$stepNameField]) && !empty($value2[$stepNameField])) :
                    ?>
                        <div id="ingredient_group_<?php echo substr($name2, -1); ?>" class="ingredient">
                            <?php foreach ($value2 as $name3 => $value3) : ?>
                                <?php if (($name3 === "nom_de_letape_" . substr($name2, -1)) && (!$value3 == "")) : ?>
                                    <h3><?php echo $value3; ?></h3>
                                <?php endif; ?>

                                <?php
                                if (preg_match('/etape_' . substr($name2, -1) . '_ingredient_\d+/', $name3)) :
                                    foreach ($value3 as $name4 => $value4) :
                                        if (($name2 ===  "etape-" . substr($name2, -1)) && (isset($value4)) && (isset(get_term($value4, "taxo-ingredient")->name)) && ($name4 === "choix_de_lingredient")) :
                                            $term = get_term($value4, "taxo-ingredient");
                                            // Affiche l'ingrédient
                                            echo '<li>' . esc_html($term->name) . ' :';

                                            // On stocke le terme pour vérifier plus tard
                                            $ingredientExists = true;
                                        endif;

                                        // Vérifie seulement si l'ingrédient existe
                                        if (isset($ingredientExists) && $ingredientExists) {
                                            if ($name4 === "quantite_1_group_1" && is_numeric($value4)) :
                                                $originalQuantity = $value4; ?>
                                                <span class="quantity" data-original="<?php echo esc_attr($originalQuantity); ?>"><?php echo esc_html($originalQuantity); ?></span>
                                                <?php endif;

                                            if ($name4 === "unite_mesure") :
                                                // Affiche l'unité de mesure uniquement si l'ingrédient existe
                                                if (isset($value4) && !empty($value4)) : ?>
                                                    <span><?php echo esc_html($value4); ?></span></li>
                                    <?php endif;
                                            endif;
                                        }
                                    endforeach;
                                    ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>