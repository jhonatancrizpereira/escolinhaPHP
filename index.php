<?php
// define variables and set to empty values
$name = $email = $gender = $comment = $website = "";
$nameErr = $emailErr = $genderErr = $websiteErr = "";

//Limpeza dos dados de entrada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Nome é obrigatório";
    } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Zà-úÀ-Ú ]*$/", $name)) {
            $nameErr = "Apenas letras e espaço em branco são permitidos";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email é obrigatório";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato de e-mail inválido";
        }
    }

    if (empty($_POST["website"])) {
        $website = "";
    } else {
        $website = test_input($_POST["website"]);
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
            $websiteErr = "URL Inválido";
        }
    }

    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = test_input($_POST["comment"]);
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }
    /** ENVIO DE EMAIL * */
    $para = 'jhonatancrizpereira@gmail.com';
    $assunto = 'email através do formulario';
    $mensagem = "De: $name <$email> \r\n";
    $mensagem .= "Website: $website \r\n";
    $mensagem .= "Gênero: $gender \r\n";
    $mensagem .= "Comentários: \r\n\n $comment";
    $headers = "From: $name <$email>" . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

    if (strlen($nameErr) == 0 &&
        strlen($emailErr) == 0 &&
        strlen($websiteErr) == 0 &&
        strlen($name) !=0 && strlen($email) != 0)
    {
        mail($para, $assunto, $mensagem, $headers);
        $statusMail = TRUE;
    } else
        $statusMail = FALSE;
    /** FIM DA FUNÇÃO DE ENVIO DE EMAIL * */
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            .err{
                outline: 1px dashed red;
                background-color: rgba(255,0,0,0.2);
            }
        </style>
    </head>
    <body>
        <h1>Manuseio de Formulario com PHP</h1>
        <h2>Referências:</h2>
        <ul>
            <li><a href="http://www.w3schools.com/php/php_forms.asp">W3Schools</a></li>
            <li><a href="http://php.net/">Manual do PHP</a></li>
        </ul>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            Name: <input type="text" name="name" class="<?= strlen($nameErr) != 0 ? "err" : ""; ?>" value="<?= $name; ?>">
            <span class="error">* <?php echo $nameErr; ?></span>
            <br><br>
            E-mail:
            <input type="text" name="email" class="<?= strlen($emailErr) != 0 ? "err" : ""; ?>" value="<?= $email; ?>">
            <span class="error">* <?php echo $emailErr; ?></span>
            <br><br>
            Website:
            <input type="text" name="website" value="<?= $website; ?>" class="<?= strlen($websiteErr) != 0 ? "err" : ""; ?>" value="<?= $website; ?>">
            <span class="error"><?php echo $websiteErr; ?></span>
            <br><br>
            Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment; ?></textarea>
            <br><br>
            Gender:
            <input type="radio" name="gender" value="female" class="<?= strlen($genderErr) != 0 ? "err" : ""; ?>" <?php if (isset($gender) && $gender == "female") echo "checked"; ?>>Female
            <input type="radio" name="gender" value="male" class="<?= strlen($genderErr) != 0 ? "err" : ""; ?>" <?php if (isset($gender) && $gender == "male") echo "checked"; ?>>Male
            <span class="error">* <?php echo $genderErr; ?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit">

        </form>

        <?php
        if (isset($statusMail) && $statusMail) {
            echo "<h1>E-mail enviado!</h1>";
        } else {
            echo "<h1 class='err'>E-mail não enviado!</h1>";
        }
        ?>

    </body>
</html>
