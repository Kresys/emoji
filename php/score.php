<?php

    ini_set('display_errors', 1);

    // CONNEXION //

    require 'connexion.php';


    // CLASSEMENT JOUEUR //

    function getClassement($idJoueur){
        global $conn;
        
        $select = "SELECT pseudo, score, FIND_IN_SET( score, ( SELECT GROUP_CONCAT( score ORDER BY score DESC ) FROM utilisateur ) ) AS rank FROM utilisateur WHERE id =".$idJoueur;
        $result_classement = mysqli_query($conn, $select);
        if (mysqli_num_rows($result_classement) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result_classement)) {
                    return [$row["rank"], $row["score"], $row["pseudo"]];
                }
            }
            else {
            echo "Impossible de charger votre classement";
        }
        return 0;
    }

    // AJOUT DU SCORE //

    function setScore($score, $id){
        global $conn;

        $update = $conn->prepare("UPDATE utilisateur SET score=?  WHERE id=?");
        $update->bind_param("dd", $score, $id);
        if($update->execute()){
            echo "<h1>Score ".$score."</h1>";
        } else{
            echo "ERROR: Could not able to execute $update. " . mysqli_error($conn);
        }
    }

    // RECUPERER LE TOP 10 //

    function getTop10(){
        global $conn;

        $top10 = array();
        $select = "SELECT pseudo, score FROM utilisateur ORDER BY score DESC LIMIT 10";
        $result_top10 = mysqli_query($conn, $select);
        if (mysqli_num_rows($result_top10) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result_top10)) {
                    array_push($top10, $row);
                }
        }
        else {
            echo "Impossible de charger votre classement";
        }
        return $top10;
    }

    // TOTAL JOUEUR

    function getTotal(){
        global $conn;

        $total = array();
        $select = "SELECT count(*) as num FROM utilisateur";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                    array_push($total, $row);
                }
        }
        else {
            echo "Impossible de charger votre classement";
        }
        return $total[0];

    }

    if(isset($_POST['action']) && !empty($_POST['action'])) {
    switch ($_POST['action']){
        case 'setScore':
            setScore($_POST['score'],$_POST['id']);
            break;
        case 'getScore':
            echo json_encode(getClassement($_POST['id']));
            break;
        case 'getTop10':
            echo json_encode(getTop10());
            break;
        case 'total':
            echo json_encode(getTotal());
    }
}

?>