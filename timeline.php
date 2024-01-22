<?php
$pdo = new PDO("mysql:host=localhost;dbname=xxxxx", 'xxxxx', 'xxxxx', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        article,
        aside,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block
        }

        a {
            color: #6d84b4;
            text-decoration: none;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 20px auto;
            font: 16px/1.4 Arial, sans-serif;
            background: #3b5998;
        }

        section {
            background: rgba(255, 255, 255, 0.9);
            padding-right: 85px;
            padding-top: 20px;
            padding-bottom: 20px;
            height: 100%;
            width: 60%;
            margin: auto;
            margin-top: -20px;
            border-radius: 5px;
            border: 1px solid #666;
        }

        .comment {
            overflow: hidden;
            padding: 0 0 1em;
            border-bottom: 1px solid #ddd;
            margin: 0 0 1em;
            margin-left: 40px;
            *zoom: 1;
            width: 100%;
        }

        .comment-img {
            float: left;
            margin-right: 33px;
            border-radius: 5px;
            overflow: hidden;
        }

        .comment-img img {
            display: block
        }

        .comment-body {
            overflow: hidden
        }

        .comment .text {
            padding: 10px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            background: #fff;
        }

        .comment .text p:last-child {
            margin: 0
        }

        .comment .attribution {
            margin: 0.5em 0 0;
            font-size: 14px;
            color: #666;
        }

        /* Decoration */

        .comments,
        .comment {
            position: relative
        }

        .comments:before,
        .comment:before,
        .comment .text:before {
            content: "";
            position: absolute;
            top: 0;
            left: 65px;
        }

        .comments:before {
            width: 3px;
            left: 105px;
            bottom: 0px;
            background: rgba(0, 0, 0, 0.1);
        }

        .comment:before {
            width: 9px;
            height: 9px;
            border: 3px solid #fff;
            border-radius: 100px;
            margin: 16px 0 0 -6px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2), inset 0 1px 1px rgba(0, 0, 0, 0.1);
            background: #ccc;
        }

        .comment:hover {
            /*  cursor: url('../images/FB_CUR.cur');  See the result on http://lab.web-gate.fr/timeline/ */
            cursor: cell;
            /* This line is for the cursor */
        }

        .comment:hover:before {
            background: #3b5998
        }

        .comment .text:before {
            top: 18px;
            left: 78px;
            width: 9px;
            height: 9px;
            border-width: 0 0 1px 1px;
            border-style: solid;
            border-color: #e5e5e5;
            background: #fff;
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            -o-transform: rotate(45deg);
        }
    </style>
</head>

<body>
    <br>
    <section class="comments">

        <?php
        if ($_POST) {
            $pseudo = strip_tags($_POST['pseudo']);
            $message = strip_tags($_POST['message']);
            $pdo->exec("INSERT INTO commentaire (pseudo,message,date_enregistrement) VALUES ('$pseudo','$message', NOW() )");
            header("Location: #form");
            exit();
        }
        $resultat = $pdo->query("SELECT * FROM commentaire");
        $nombreDeCom = $resultat->rowCount();
        $commentaires = $resultat->fetchAll(PDO::FETCH_ASSOC);

        foreach ($commentaires as $commentaire) {
            $color = getColorFromString($commentaire["pseudo"]);
            $firstChar = substr($commentaire["pseudo"], 0, 1);
            echo '<article class="comment">
            <a class="comment-img" href="#non">
                <div style="width: 50px; height: 50px; background-color: ' . $color . '; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">
                    ' . $firstChar . '
                </div>
            </a>
                
            <div class="comment-body">
                <div class="text">
                  <p>' . $commentaire["message"] . '</p>
                </div>
                <p class="attribution">by <a href="#non">' . $commentaire["pseudo"] . '</a> at ' . $commentaire["date_enregistrement"] . '</p>
            </div>
        </article>';
        }

        /**
         * Summary of getColorFromString
         * @param mixed $string
         * @return string
         */
        function getColorFromString($string)
        {
            // Génère un nombre unique à partir de la chaîne de caractères donnée
            $hash = md5($string);

            // Sépare les 3 parties du hash en 2 caractères chacune
            $r = substr($hash, 0, 2);
            $g = substr($hash, 2, 2);
            $b = substr($hash, 4, 2);

            // Convertit les parties hexadécimales en décimales
            $r = hexdec($r);
            $g = hexdec($g);
            $b = hexdec($b);

            // Retourne la couleur au format RGB
            return "rgb($r, $g, $b)";
        }

        ?>


        <article class="comment">
            <a class="comment-img" href="#non">
                <div
                    style="width: 50px; height: 50px; background-color: white; display: flex; align-items: center; justify-content: center; color: rgba(0, 0, 0, 0.2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                </div>
            </a>

            <div class="comment-body">
                <div class="text">

                    <form action="" method="post">
                        <label class="attribution" for="pseudo">Pseudo :</label>
                        <br>
                        <input class="text" type="text" name="pseudo">
                        <br><br>
                        <label class="attribution" for="message">Message :</label>
                        <br>
                        <input class="text" type="text" name="message">
                        <br><br>
                        <input class="text" type="submit" value="envoyer">
                    </form>


        </article>
        <p style="font-size: 14px; color: #666; text-align: right; margin: 0;">
            <?php
            if ($nombreDeCom >= 2) {
                $pl = "s";
            } else {
                $pl = "";
            }
            echo $nombreDeCom . ' commentaire' . $pl . ' publié' . $pl;

            ?>
        </p>
    </section>​


</body>

</html>
