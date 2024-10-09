<div id="groupe description-etapes">
    <?php // echo acf_get_fields('etape_1_ingredient_1')  


    $list_champs = get_fields();
    if (get_fields() !== false) : ?>
        <?php foreach ($list_champs as $name => $value) : ?>



            <?php if ($name === "nbresetapes") : ?>
                <!------------------------------------------    rajouter un compteur pour le nbre d etape------------------------------------------------->
                <!-------------------------------------------  rajouter d element pour la securité ( verifi nbre ,verif chaine)-------------------------------------------------------->
                <?php foreach ($value as $name2 => $value2) : ?>

                    <?php if ((isset($value2)) && $name2 === "etape-1") : ?>
                        <div id="description_group_1" class="description">
                            <?php foreach ($value2 as $name3 => $value3) : ?>

                                <?php
                                if (($name3 === "nom_de_letape_1") && (!$value3 == "")) : ?>
                                    <h3>

                                        <?php echo $value3; ?> <!-- affiche le nom de l'etape -->

                                    </h3>
                                <?php
                                endif ?>
                                <?php
                                if ((isset($value3)) && ($name3 === "description_étape_1")&& (!$value3 == "")
                                ) : ?>
                                    <li> <?php echo $value3; ?> <!-- affiche la valeur de la taxonomie ingredient-->

                                    </li>

                                <?php endif; ?>
                                  <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


  


                    <?php if ((isset($value2)) && $name2 === "etape-2") : ?>
                        <div id="description_group_2" class="description">
                            <?php foreach ($value2 as $name3 => $value3) : ?>

                                <?php
                                if (($name3 === "nom_de_letape_2") && (!$value3 == "")) : ?>
                                    <h3>

                                        <?php echo $value3; ?> <!-- affiche le nom de l'etape -->

                                </h3>
                                <?php
                                endif ?>
                                <?php
                                if ((isset($value3)) && ($name3 === "description_étape_2")&& (!$value3 == "")
                                ) : ?>
                                    <li> <?php echo $value3; ?>  <!-- affiche la valeur de la taxonomie ingredient-->

                                    </li>

                                <?php endif; ?>
                                  <?php endforeach; ?>
                        </div>
                    <?php endif; ?>





                    <?php if ((isset($value2)) && $name2 === "etape-3") : ?>
                        <div id="description_group_3" class="description">
                            <?php foreach ($value2 as $name3 => $value3) : ?>

                                <?php
                                if (($name3 === "nom_de_letape_3") && (!$value3 == "")) : ?>
                                    <h3>

                                        <?php echo $value3; ?> <!-- affiche le nom de l'etape -->

                                </h3>
                                <?php
                                endif ?>
                                <?php
                                if ((isset($value3)) && ($name3 === "description_étape_3")&& (!$value3 == "")
                                ) : ?>
                                    <li> <?php echo $value3; ?> <!-- affiche la valeur de la taxonomie ingredient-->

                                    </li>

                                <?php endif; ?>
                                  <?php endforeach; ?>
                        </div>
                    <?php endif; ?>



                    <?php if ((isset($value2)) && $name2 === "etape-4") : ?>
                        <div id="description_group_4" class="description">
                            <?php foreach ($value2 as $name3 => $value3) : ?>

                                <?php
                                if (($name3 === "nom_de_letape_4") && (!$value3 == "")) : ?>
                                    <h3>

                                        <?php echo $value3; ?> <!-- affiche le nom de l'etape -->

                                </h3>
                                <?php
                                endif ?>
                                <?php
                                if ((isset($value3)) && ($name3 === "description_étape_4")&& (!$value3 == "")
                                ) : ?>
                                    <li> <?php echo $value3; ?>  <!-- affiche la valeur de la taxonomie ingredient-->

                                    </li>

                                <?php endif; ?>
                                  <?php endforeach; ?>
                        </div>
                    <?php endif; ?>



                    <?php if ((isset($value2)) && $name2 === "etape-5") : ?>
                        <div id="description_group_5" class="description">
                            <?php foreach ($value2 as $name3 => $value3) : ?>

                                <?php
                                if (($name3 === "nom_de_letape_5") && (!$value3 == "")) : ?>
                                    <h3>

                                        <?php echo $value3; ?> <!-- affiche le nom de l'etape -->

                                </h3>
                                <?php
                                endif ?>
                                <?php
                                if ((isset($value3)) && ($name3 === "description_étape_5")&& (!$value3 == "")
                                ) : ?>
                                    <li> <?php echo $value3; ?>  <!-- affiche la valeur de la taxonomie ingredient-->

                                    </li>

                                <?php endif; ?>
                                  <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


                <?php endforeach; ?>
            <?php endif; ?>


    <?php endforeach;
    endif; ?>




</div>