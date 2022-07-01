<?php
if (isset($_SESSION['melding'])) {
    echo '<p style = "color:red;">' . $_SESSION['melding'] . '</p>';
    unset($_SESSION['melding']);


} ?>

<h2>Welkom in MyBuddy</h2>

<form action="php/login.php" method="post">

    <div class="container">
        <label for="uname"><b>Email</b></label>
        <input type="text" placeholder="Enter Username" name="email" required>

        <label for="psw"><b>Wachtwoord</b></label>
        <input type="password" placeholder="Wachtwoord" name="psw" required>

        <button type="submit">Login</button>
        <button class="btn btn-success" onclick="window.location.href='index.php?page=register'">Registreren</button>


    </div>


</form>


