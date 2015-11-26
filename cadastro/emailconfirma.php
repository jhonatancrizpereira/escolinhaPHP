<?php

function emailconfirma($email, $link) {

    // multiplos destinatarios
    $to = $email . ', '; // notar a virgula
    $to .= 'jhonatancrizpereira@gmail.com';

// Assunto
    $subject = 'Confirmação de cadastro [nome do site]';

// Mensagem
    $message = '
        <html>
            <head>
                <title>Confirmação de cadastro [nome do site]</title>
            </head>
            <body>
                <center><img src='http://www.noticenter.com.br/geral/img/empresas/senai.jpg' alt='logo do SENAI'/></center>
                <h1>Confirmação de e-mail</h1>
                <p>Recentemente o email $email foi cadastrado em nossa lista para se manter informado com as ultimas noticias do [nome do site]</p>
                <p>Para completar o cadastro, favor confirmar clicnado no link abaixo:</p>
                <p>$link</p>
            </body>
        </html>
    ';

// To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset = utf-8' . "\r\n";

// Additional headers
    $headers .= 'To: $email' . "\r\n";
    $headers .= 'From: Nome do site <jhonatancrizpereira@gmail.com>';

// Mail it
    mail($to, $subject, $message, $headers);
}
