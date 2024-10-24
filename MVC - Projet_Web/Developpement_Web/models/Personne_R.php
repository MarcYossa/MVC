class Personne_R {
    private $id_personne;
    private $id_compte;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $adresse;
    private $poste;
    private $date_naissance;

    public function __construct($id_personne, $id_compte, $nom, $prenom, $email, $telephone = null, $adresse = null, $poste, $date_naissance) {
        $this->id_personne = $id_personne;
        $this->id_compte = $id_compte;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->poste = $poste;
        $this->date_naissance = $date_naissance;
    }
}