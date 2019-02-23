E-Sportial


BDD

Table Type externalisée car utiliée dans les select avec des valeurs que nous avons defini  

**Standards**

Files twig / js / scss : snake_case

Structure of twig / js / scss files :

    - 1 folder back and front
    - 1 folder per controller
    - 1 folder per route in controllers folders    
    - 1 file per page(route) that include modules
    - 1 module per block of the page
    
    exemple :
        Controller User with list / edit / show routes
        templates
            -> pages
                -> front
                    -> user
                        -> list.html.twig
                        -> edit.html.twig
                        -> show.html.twig
            -> modules
                -> front
                    -> user
                        -> list
                            -> list_form.html.twig
                            -> user_table.html.twig
                        -> edit
                            -> edit_form.html.twig
                        -> show
                            -> user_detail.html.twig
                            -> history.html.twig
                            -> games_played.html.twig
                           
