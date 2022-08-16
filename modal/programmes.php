<?php

require_once __DIR__ . '../../include/config.php';

class modal_programmes {
    public $id;
    public $titre_programme;
    public $titre_cours;
    public $nom_etudiant;
    public $prenom_etudiant;
    public $etudiant_id;
    
    <!-- fonction pour contruire un objet de type modal_programme -->
    public function __construct($id, $titre_programme, $titre_cours, $nom_etudiant, $prenom_etudiant, $etudiant_id) {
        $this->id = $id;        
        $this->etudiant_id = $etudiant_id;
        $this->titre_programme = $titre_programme;
        $this->titre_cours = $titre_cours;
        $this->nom_etudiant = $nom_etudiant;
        $thisprenom_etudiant = $prenom_etudiant;
        
    }

   <!-- Fonction pour permettre de se connecter à la BBD-->
   static function connecter() {

    $mysqli = new mysqli(Db::$host, Db::$username, Db::$password, Db::$database);

    // vérifier la connexion
    if ($mysqli -> connect_errno) {
        echo "Échec de la connexion à la base de données MySQL:" . $mysqli -> connect_error;
        exit();
    }

    return $mysqli;
   }

   <!-- fonction pour récupérer tout le programme -->
   public static function ObtenirTous() {
    $liste =[];
    $mysqli = self::connecter();

        $resultatRequete = $mysqli->query("SELECT programmes.id AS programme_id, etudiant_id, titre_programme, titre_cours, nom_etudiant, prenom_etudiant FROM etudiants INNER JOIN on etudiants.fk_programme = id_programme");

        foreach ($resultatRequete as $enregistrement) {
        $liste[] = new modal_programme($enregistrement['programme_id'], $enregistrement['etudiant_id'], $enregistrement['titre_programme'], $enregistrement['titre_cours'], $enregistrement['nom_etudiant'], $enregistrement['prenom_etudiant']);
        }

        return $liste;
    }

    <!-- fonction pour ajouter un programme -->
    public static function ajouter($ $etudiant_id)
    

}

?>
