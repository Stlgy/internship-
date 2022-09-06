<?php

    if (isset($_POST['submit'])) {
        $_POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
        $name = $email = $subject = $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_POST["name"] = test_input($_POST["name"]);
            $_POST["email"] = test_input($_POST["email"]);
            $_POST["subject"] = test_input($_POST["subject"]);
            $_POST["message"] = test_input($_POST["message"]);
            
            //$zone= date_default_timezone_set('Europe/Lisbon');
            $date ->setTimezone(new DateTimeZone('Europe/Lisbon'));
            $date= DateTime::createFromFormat('d/m/Y H:i:s',$date);
           
            function test_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                return $data;
            }
            if (!preg_match("/^[A-Za-z .'-]+$/", $_POST["name"])) {
                $name_error = 'Nome invalido!';
            }
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $email_error = 'Email invalido!';
            }
            if (!preg_match("/^[A-Za-z .'-]+$/", $_POST["subject"])) {
                $subject_error = 'Assunto invalido!';
            }
            if (strlen($_POST["subject"]) === 0) {
                $message_error = 'O seu e-mail não tem assunto';
            }
            if (strlen($_POST["message"]) === 0) {
                $message_error = 'O seu e-mail não tem conteúdo';
            }
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <title>Formulario de contacto</title>
</head>

<body>

    <h1>Contacte-nos</h1>
    <p> Something something...</p>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Nome:</label>><input type="text" name="name" id="name" /><br />
        <?php if (isset($name_error)) echo '<p>' . $name_error . '</p>'; ?>
        <label for="email">E-mail:</label><input type="text" name="email" id="email" /><br />
        <?php if (isset($email_error)) echo '<p>' . $email_error . '</p>'; ?>
        <label for="assunto">Assunto:</label><input type="text" name="subject" id="subject" /><br />
        <?php if (isset($subject_error)) echo '<p>' . $subject_error . '</p>'; ?>
        <label for="message">Mensagem:</label><textarea name="message"></textarea><br />
        <?php if (isset($message_error)) echo '<p>' . $message_error . '</p>'; ?>
        
        <button type="submit" name="submit" >Enviar</button>

        <?php
        if (isset($_POST['submit']) && !isset($name_error) && !isset($email_error) && !isset($subject_error) && !isset($message_error)) {
            $to = 'ideiasfrescas@gmail.com';
            $body = 'De: ' .  $_POST["name"] . "\r\n" .
                    'E-mail: ' . $_POST["email"] . "\r\n" .
                    'Assunto: ' . $_POST["subject"] . "\r\n" .
                    'Mensagem: ' . $_POST["message"];

            $headers = 'De: ' . $_POST["email"] . "\r\n" .
                       'Assunto: ' . $_POST["subject"] . $date . "h" . "\r\n";
                       
                            
            if (mail($to, $subject, $body, $headers)) {
                $msg = "E-mail enviado com sucesso";
            } else {
                $msg = "Não foi possível enviar o seu e-mail, por favor tente mais tarde.";
            }
        }
        ?>
    </form>
</body>

</html>
