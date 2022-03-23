<html>
    <head>
        <title>Notatnik</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link href="/public/style.css" rel="stylesheet">
    </head>

    <body>
        <wrapper>
            <header>
                <h1>Moje notatki</h1>
            </header>

            <container>
                <menu>
                    <ul>
                        <li>
                            <a href="/">Lista notatek</a>
                        </li>
                        <li>
                            <a href="/?action=create">Nowa notatka</a>
                        </li>
                    </ul>
                </menu>
                <page>
                    <?php

                    include_once("templates/pages/$page.php");
                    ?>
                </page>
            </container>

            <footer>

            </footer>
        </wrapper>
    </body>
</html>