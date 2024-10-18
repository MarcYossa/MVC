class Panier {
    private $id_panier;
    private $id_utilisateur;
    private $total_article;
    private $pdo;

    public function __construct($pdo, $id_panier, $id_utilisateur, $total_article) {
        $this->pdo = $pdo;
        $this->id_panier = $id_panier;
        $this->id_utilisateur = $id_utilisateur;
        $this->total_article = $total_article;
    }
}