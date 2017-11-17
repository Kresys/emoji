<?php 

    // CONNEXION //

    require 'connexion.php';

    
    
    
function getGame(){
    global $conn;

    // ENIGME //

    $requete_enigme = "SELECT id, phrase, niveau, solution, suggestions, categorie FROM enigme";
    $result_enigme = mysqli_query($conn, $requete_enigme);

    $liste_enigme_niveau1 = array();
    $liste_enigme_niveau2 = array();
    $liste_enigme_niveau3 = array();
    $liste_enigme_niveau4 = array();

    if (mysqli_num_rows($result_enigme) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result_enigme)) {
            $liste_solution = explode(",", $row["solution"]);
            $liste_suggestions = explode(",", $row["suggestions"]);
            shuffle($liste_suggestions);
            $row["solution"] = $liste_solution;
            $row["suggestions"] = $liste_suggestions;
            switch( $row["niveau"] ){
                case 1:
                    array_push($liste_enigme_niveau1, $row);
                    break;
                case 2:
                    array_push($liste_enigme_niveau2, $row);
                    break;
                case 3:
                    array_push($liste_enigme_niveau3, $row);
                    break;
                case 4:
                    array_push($liste_enigme_niveau4, $row);
                    break;
            }
        }
    } else {
        echo "Impossible de trouver une énigme";
    }

    shuffle($liste_enigme_niveau1);
    shuffle($liste_enigme_niveau2);
    shuffle($liste_enigme_niveau3);
    shuffle($liste_enigme_niveau4);


    // ANNONCES //

    $requete_annonce = "SELECT id, phrase, personnage, niveau FROM annonces";
    $result_annonce = mysqli_query($conn, $requete_annonce);
    
    $liste_annonce_niveau1 = array();
    $liste_annonce_niveau2 = array();
    $liste_annonce_niveau3 = array();
    $liste_annonce_niveau4 = array();

    if (mysqli_num_rows($result_annonce) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result_annonce)) {
            switch( $row["niveau"] ){
                case 1:
                    array_push($liste_annonce_niveau1, $row);
                    break;
                case 2:
                    array_push($liste_annonce_niveau2, $row);
                    break;
                case 3:
                    array_push($liste_annonce_niveau3, $row);
                    break;
                case 4:
                    array_push($liste_annonce_niveau4, $row);
                    break;
            }
        }
    } else {
        echo "Impossible de charger les annonces";
    }

    shuffle($liste_annonce_niveau1);
    shuffle($liste_annonce_niveau2);
    shuffle($liste_annonce_niveau3);
    shuffle($liste_annonce_niveau4);


    // JEU

    $game = array();
    $niveaux = array();
    array_push($niveaux,array_slice($liste_enigme_niveau1, 0, 5));
    array_push($niveaux,array_slice($liste_enigme_niveau2, 0, 5));
    array_push($niveaux,array_slice($liste_enigme_niveau3, 0, 5));
    array_push($niveaux,array_slice($liste_enigme_niveau4, 0, 99));
    $annonces = array();
    array_push($annonces,$liste_annonce_niveau1[0]);
    array_push($annonces,$liste_annonce_niveau2[0]);
    array_push($annonces,$liste_annonce_niveau3[0]);
    array_push($annonces,$liste_annonce_niveau4[0]);
    array_push($game, $niveaux);
    array_push($game, $annonces);

    return $game;
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    switch ($_POST['action']){
        case 'getDatas':
            $res = getGame();
            echo json_encode($res);;
            break;
    }
}

mysqli_close($conn);
?>