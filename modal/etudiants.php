<?php

require_once __DIR__ . '../../include/config.php';

class modal_etudiant {
    public $id; 
    public $nom_complet; 

    // Fonction permettant de construire un objet de type modele_etudiant

    public function __construct($id, $nom, $prenom) {
        $this->id = $id;
        $this->nom_complet = $nom . ', ' . $prenom;
    }

    // Fonction permettant de se connecter à la base de données
    static function connecter() {
        
        $mysqli = new mysqli(Db::$host, Db::$username, Db::$password, Db::$database);

        // Vérifier la connexion
        if ($mysqli -> connect_errno) {
            echo "Échec de connexion à la base de données MySQL: " . $mysqli -> connect_error;   // Pour fins de débogage
            exit();
        } 

        return $mysqli;
    }

    /***
     * Fonction permettant de récupérer l'ensemble des clients 
     */
    public static function ObtenirTous() {
        $liste = [];
        $mysqli = self::connecter();

        $resultatRequete = $mysqli->query("SELECT * FROM etudiants ORDER BY nom, prenom");

        foreach ($resultatRequete as $enregistrement) {
            $liste[] = new modal_etudiant($enregistrement['id'], $enregistrement['nom'], $enregistrement['prenom']);
        }

        return $liste;
    }
}

?>