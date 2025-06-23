<?php

namespace SGDB_API\Controllers;

class ErrorPage
{
    public function page404()
    {
        http_response_code(404);
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>404 Non Trouvé</title>
            <style>
                body {
                    background: #f8f9fa;
                    color: #333;
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding-top: 10%;
                }
                h1 {
                    font-size: 4em;
                    margin-bottom: 0.2em;
                    color: #dc3545;
                }
                p {
                    font-size: 1.5em;
                }
                a {
                    color: #007bff;
                    text-decoration: none;
                }
                a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <h1>404</h1>
            <p>Désolé, la page que vous recherchez est introuvable.</p>
            <p><a href="/sgdb_api/">Retour à l'accueil</a></p>
        </body>
        </html>
        <?php
    }
}
