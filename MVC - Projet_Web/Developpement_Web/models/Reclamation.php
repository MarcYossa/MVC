class Reclamation {
    private $id_reclamation;
    private $id_utilisateur;
    private $id_commande;
    private $description;
    private $date_reclamation;
    private $pdo;

    public function __construct($pdo, $id_reclamation, $id_utilisateur, $id_commande, $description, $date_reclamation = null) {
        $this->pdo = $pdo; // Stocker la connexion PDO
        $this->id_reclamation = $id_reclamation;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_commande = $id_commande;
        $this->description = $description;
        $this->date_reclamation = $date_reclamation;
    }
}
