class Reponse {
    private $id_reponse;
    private $date_arrivee;
    private $description;
    private $statut_r;
    private $date_resolution;
    private $pdo;

    public function __construct($pdo, $id_reponse, $date_arrivee = null, $description, $statut_r, $date_resolution = null) {
        $this->pdo = $pdo;
        $this->id_reponse = $id_reponse;
        $this->date_arrivee = $date_arrivee;
        $this->description = $description;
        $this->statut_r = $statut_r;
        $this->date_resolution = $date_resolution;
    }
}