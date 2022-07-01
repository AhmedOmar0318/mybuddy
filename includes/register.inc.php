<?php
if (isset($_SESSION['melding2'])) {
    echo '<p style = "color:red;">' . $_SESSION['melding2'] . '</p>';
    unset($_SESSION['melding2']);
} ?>

<form action="php/register.php" method="post">
    <div class="container">

        <h1>Register</h1>

        <p>Please fill in this form to create an account.</p>

        <hr>

        <label for="email"><b>Voornaam</b></label>
        <input type="text" placeholder="Voornaam" name="firstname" required>

        <label for="email"><b>Tussenvoegsel</b></label>
        <input type="text" placeholder="Tussenvoegsel" name="middlename">

        <label for="email"><b>Achternaam</b></label>
        <input type="text" placeholder="Achternaam" name="lastname" required>

        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Email" name="email" required><br>

        <br><label for="psw"><b>Wachtwoord</b></label>
        <input type="password" placeholder="Wachtwoord" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Herhaal wachtwoord</b></label>
        <input type="password" placeholder="Wachtwoord" name="pswrepeat" id="pswrepeat" required>
        <hr>


    </div>

    <button type="submit">Registreer</button>
</form>
