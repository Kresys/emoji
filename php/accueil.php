<html>
    <body>
        <h1>Test</h1>
        <?php 
            require 'connexion.php';
        ?>
        <br>
        <h1>Connexion</h1>
        <form action="./game.php" method="post"> 
            <input type="text" name="pseudo" placeholder="pseudo"><br/>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>


