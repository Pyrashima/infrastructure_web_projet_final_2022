<?php
require_once __DIR__ . '../../include/config.php';

class modal_presences {
    public $id; 
    public $nombre_abscence; 
    public $date_presence;
    public $duree;
    public $nom_etudiant;
    public $prenom_etudiant;

    /***
     * Fonction permettant de construire un objet de type modele_produit
     */
    public function __construct($id, $code, $produit, $prix_unitaire, $prix_vente, $qte_stock) {
        $this->id = $id;
        $this->nombre_abscence = $absence;
        $this->date_presence = $presence;
        $this->duree = $duree;
        $this->nom_etudiant = $nom_etudiant;
        $this->prenom_etudiant = $prenom_etudiant;
    }

    /***
     * Fonction permettant de se connecter à la base de données
     */
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
     * Fonction permettant de récupérer l'ensemble des produits 
     */
    public static function ObtenirTous() {
        $liste = [];
        $mysqli = self::connecter();

        $resultatRequete = $mysqli->query("SELECT id, nom, prenom, adresse, ville, code_postal, courriel, telephone FROM etudiants ORDER BY presences");

        foreach ($resultatRequete as $enregistrement) {
            $liste[] = new modal_etudiant($enregistrement['id'], $enregistrement['nom'], $enregistrement['prenom'], $enregistrement['adresse'], $enregistrement['ville'], $enregistrement['code_postal'] $enregsitrement['courriel'], $enregistrement['telephone']);
        }

        return $liste;
    }

    /***
     * Fonction permettant de récupérer un produit en fonction de son identifiant
     */
    public static function ObtenirUn($id) {
        $mysqli = self::connecter();

        if ($requete = $mysqli->prepare("SELECT * FROM etudiants WHERE id=?")) {  // Création d'une requête préparée 
            $requete->bind_param("s", $id); // Envoi des paramètres à la requête

            $requete->execute(); // Exécution de la requête

            $result = $requete->get_result(); // Récupération de résultats de la requête¸
            
            if($enregistrement = $result->fetch_assoc()) { // Récupération de l'enregistrement
                $produit = new modal_presence($enregistrement['id'], $enregistrement['nombre_absence'], $enregistrement['date_presence'], $enregistrement['duree'], $enregistrement['nom_etudiant'], $enregistrement['prenom_etudiant']);
            } else {
                //echo "Erreur: Aucun enregistrement trouvé.";  // Pour fins de débogage
                return null;
            }   
            
            $requete->close(); // Fermeture du traitement 
        } else {
            echo "Une erreur a été détectée dans la requête utilisée : ";   // Pour fins de débogage
            echo $mysqli->error;
            return null;
        }

        return $produit;
    }

    /***
     * Fonction permettant d'ajouter un étudiant
     */
    public static function ajouter($nom, $presence, $adresse, $ville, $province, $code_postal, $telephone) {
        $message = '';

        $mysqli = self::connecter();
        
        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("INSERT INTO etudiants(nom, prenom, adresse, ville, province, code_postal, telephone) VALUES(?, ?, ?, ?, ?)")) {      


        $requete->bind_param("ssddi", $nom, $prenom, $adresse, $ville, $province, $code_postal, $telephone);

        if($requete->execute()) { // Exécution de la requête
            $message = "Produit ajouté";  // Message ajouté dans la page en cas d'ajout réussi
        } else {
            $message =  "Une erreur est survenue lors de l'ajout: " . $requete->error;  // Message ajouté dans la page en cas d’échec
        }

        $requete->close(); // Fermeture du traitement

        } else  {
            echo "Une erreur a été détectée dans la requête utilisée : ";   // Pour fins de débogage
            echo $mysqli->error;
            echo "<br>";
            exit();
        }

        return $message;
    }

    /***
     * Fonction permettant d'éditer une presence
     */
    public static function editer($id, $nombre_abscence, $date_presence, $date_presence, $nom_etudiant, $prenom_etudiant, $titre_programme) {
        $message = '';

        $mysqli = self::connecter();
        
        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("UPDATE produits SET code=?, produit=?, prix_unitaire=?, prix_vente=?, qte_stock=? WHERE id=?")) {      


        $requete->bind_param("ssddii", $code, $nom, $prix_unitaire, $prix_vente, $qte_stock, $id);

        if($requete->execute()) { // Exécution de la requête
            $message = "Produit modifié";  // Message ajouté dans la page en cas d'ajout réussi
        } else {
            $message =  "Une erreur est survenue lors de l'édition: " . $requete->error;  // Message ajouté dans la page en cas d’échec
        }

        $requete->close(); // Fermeture du traitement

        } else  {
            echo "Une erreur a été détectée dans la requête utilisée : ";
            echo $mysqli->error;
            echo "<br>";
            exit();
        }

        return $message;
    }

    /***
     * Fonction permettant de supprimer un produit
     */
    public static function supprimer($id) {
        $message = '';

        $mysqli = self::connecter();
        
        // Création d'une requête préparée
        if ($requete = $mysqli->prepare("DELETE FROM produits WHERE id=?")) {      

        /************************* ATTENTION **************************/
        /* On ne fait présentement peu de validation des données.     */
        /* On revient sur cette partie dans les prochaines semaines!! */
        /**************************************************************/

        $requete->bind_param("i", $id);

        if($requete->execute()) { // Exécution de la requête
            $message = "Produit supprimé";  // Message ajouté dans la page en cas d'ajout réussi
        } else {
            $message =  "Une erreur est survenue lors de la suppression: " . $requete->error;  // Message ajouté dans la page en cas d’échec
        }

        $requete->close(); // Fermeture du traitement

        } else  {
            echo "Une erreur a été détectée dans la requête utilisée : ";
            echo $mysqli->error;
            echo "<br>";
            exit();
        }

        return $message;
    }
}

?>