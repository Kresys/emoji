<?php

    require 'connexion.php';

    function insertJoueur($pseudo){
        //$pseudo = mysqli_real_escape_string($conn, $_REQUEST['pseudo']);
        global $conn;

        $insert = $conn->prepare("INSERT INTO utilisateur(pseudo) VALUES(?)");
        $insert->bind_param("s", $pseudo);

        if($insert->execute()){
            $last_id = mysqli_insert_id($conn);
        } else{
            echo "ERROR: Could not able to execute $insert. " . mysqli_error($conn);
        }

        return $last_id;
    }

    $pseudo = htmlentities($_REQUEST['pseudo']);

    $id = insertJoueur($pseudo);
    
    mysqli_close($conn);

    header('Location: ../templates/game.html?id='.$id);

?>