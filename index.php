<?php

    declare(strict_types=1);

    namespace App;

    require_once("src/utils/debug.php");

    $action = $_GET['action'] ?? null;

?>

<html>
    <head>

    </head>

    <body>
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
        </container>

        <footer>

        </footer>

    </body>
</html>