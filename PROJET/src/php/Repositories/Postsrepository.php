<?php

namespace App\php\Repositories;

use App\php\Contenants\Post;
require_once 'Repository.php';


class Postsrepository extends Rechercherepository
{
    private $limit = 12;
    private $page;
    private $offset;

    private $recherche;
    public function __construct()
    {
        $this->autoSQL();
        $num = func_num_args();
        switch ($num) {
            case 3: $this->__construct1(func_get_arg(0), func_get_arg(1),func_get_arg(2)); break;
        }

    }



    private function __construct1($page_, $limit_, $recherche_):void
    {
        $this->page = $page_;
        $this->limit = $limit_ >= 0 ? (int)$limit_ : $this->limit;
        $this->offset = ($this->page - 1) * $this->limit;
        $this->recherche = $recherche_;
    }

    protected function getWhere(){
        /*
         * Récupère (return) la clause where SQL spécialement assemblé avec la recherche et les colonnes d'un poste
         */
        $words=explode(" ",trim($this->recherche));
        $where = "";
        if (!empty($words) && $words[0] !== "") {
            $rec = [];
            foreach ($words as $word) {
                $rec[] = "CONCAT(titre, ' ', description, ' ', e.nom,' ',v.nom,' ',v.code_postal,' ',c.type) LIKE '%".$word."%'";
            }
            $where = "WHERE " . implode(" AND ", $rec);
        }
        return $where;
    }


    public function getPageData()
    {
        /*
         * retourne un array d'offres selon le where de la recherche (pour la page recherche)
         */
        $where = $this->getWhere();
        $query = ("select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille,
                   remuneration,d.date as date_post,d2.date as date_debut,d3.date as date_fin,nb_de_postulations,nombre_wishlist,
                    e.nom as entreprise,v.nom as ville ,c.type as contrat 
                    FROM bdd_web.posts
                      left JOIN bdd_web.date d ON d.id = posts.id_date_post
                      left join bdd_web.date d2 ON d2.id = posts.id_date_debut
                      left join bdd_web.date d3 ON d3.id = posts.id_date_fin
                      left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                      left JOIN bdd_web.adresse a ON posts.id_adresse = a.id
                      left JOIN bdd_web.ville v ON a.id_ville = v.id
                      left JOIN bdd_web.contrat c on posts.id_contrat = c.id
                    $where
                    order by date_post LIMIT ? OFFSET ? ");
        $result = $this->getSearchData($query,$this->limit,$this->offset);
        $posts=[];
        while ( $data = $result->fetch_assoc()) {
            $posts[] =
                new Post(
                    (int)$data['id'],
                    $data['titre'],
                    $data['description_pointille'],
                    $data['date_post'],
                    "",
                    "",
                    "",
                    $data['ville'],
                    "",
                    "",
                    (int)$data['nb_de_postulations'],
                    $data['entreprise'],
                    $data['remuneration'],
                    $data['date_debut'],
                    $data['date_fin'],
                    (int)$data['nombre_wishlist'],
                    $data['contrat'],
                    "",
                    ""
                )
            ;
        }
        $result->close();
        return $posts;
    }


    public function getALLCount()
    {
        /*
         * Récupère le total d'offres associée a une recherche
         */
        $where = $this->getWhere();
        $query = ("select count(posts.id) as nb
                    FROM bdd_web.posts
                      left JOIN bdd_web.date d ON d.id = posts.id_date_post
                      left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                      left JOIN bdd_web.adresse a ON posts.id_adresse = a.id
                      left JOIN bdd_web.ville v ON a.id_ville = v.id
                      left JOIN bdd_web.contrat c on posts.id_contrat = c.id
                    $where
                    order by d.date ");
        $row =$this->SQL->prepare($query);
        $row->execute();
        $result = $row->get_result();
        $data = $result->fetch_assoc();
        $result->close();
        if ($data==null){
            $data['nb']=1;
        }
        return (int)$data['nb'];
    }

    public function getNbPosts()
    {
        /*
         * Retourne le nombre total de posts
         */
        $query="select count(posts.id) as nb from bdd_web.posts";
        $row =$this->SQL->prepare($query);
        $row->execute();
        $result=$row->get_result();
        $data = $result->fetch_assoc();
        return (int)$data['nb'];
    }


    public function getPostsByIdEntreprise($id_entreprise)
    {
        /*
         * Retourne tous les posts associé a une entreprise
         */
        $query="SELECT po.id as id,po.titre as titre ,po.description as description,e.email as email,t.numero as telephone,
                   po.nb_de_postulations,e2.nom as entreprise,a.adresse,v.nom as ville,v.code_postal as code_postal,p.nom as pays,po.remuneration,
                   d2.date as date_debut,d3.date as date_fin,po.nombre_wishlist,c.type as contrat,d.semaines as duree,d1.date as date_creation
                   FROM bdd_web.posts po
                     left join bdd_web.duree d on po.id_duree = d.id
                     left join bdd_web.date d1 on po.id_date_post = d1.id
                     left join bdd_web.date d2 on d2.id = po.id_date_debut
                     left join bdd_web.date d3 on d3.id = po.id_date_fin
                     left join bdd_web.email e on e.id = po.id_email
                     left join bdd_web.contrat c on po.id_contrat = c.id
                     left join bdd_web.telephone t on po.id_telephone = t.id
                     left join bdd_web.entreprise e2 on e2.id = po.id_entreprise
                     left join bdd_web.adresse a on po.id_adresse = a.id
                     left join bdd_web.ville v on v.id = a.id_ville
                     left join bdd_web.pays p on v.id_pays = p.id
                   where id_entreprise=?";
        $result=$this->ExecuteQueryByID($query,$id_entreprise);
        $posts=[];
        while ($data = $result->fetch_assoc()) {
            $posts[] = new Post(
                (int)$data['id'],
                $data['titre'],
                $data['description'],
                $data['date_creation'],
                $data['email'],
                $data['telephone'],
                $data['adresse'],
                $data['ville'],
                $data['code_postal'],
                $data['pays'],
                (int)$data['nb_de_postulations'],
                $data['entreprise'],
                $data['remuneration'],
                $data['date_debut'],
                $data['date_fin'],
                (int)$data['nombre_wishlist'],
                $data['contrat'],
                $data['duree'],
                $this->getCompetencesByID((int)$data['id'])
            );

        }
        $result->close();
        return $posts;
    }


    public function DeleteDataByID($id_)
    {
        $query="DELETE FROM bdd_web.posts WHERE id=?";
        $result=$this->ExecuteQueryByID($query,$id_);
        if ($result->affected_rows ==1) {
            $result->close();
            return true;
        }
        $result->close();
        return false;
    }

    public function UpdateDataByID($id_,$contenant_)
    {
        $query="UPDATE posts
                SET titre = ? , description = ?, id_email = ?, id_telephone = ?, nb_de_postulations = ?, id_entreprise= ?, id_adresse = ?,
                    remuneration = ?, id_date_debut =?, id_date_fin = ?, nombre_wishlist = ?, id_contrat = ?, id_duree = ?, id_date_post =?
                    WHERE $id_= ? ; ";

        $row =$this->SQL->prepare($query);
        $row->bind_param("ssiiiiisiiiiiii",$contenant_->getTitre(),$contenant_->getDescription(),$contenant_->getEmail(),
            $contenant_->getTelephone(),$contenant_->getNbPostulations(),$contenant_->getEntreprise(),$contenant_->getAdresse(),
            $contenant_->getRemuneration(),$contenant_->getDateDebut(),$contenant_->getDateFin(),$contenant_->getNbWhishlist(),
            $contenant_->getContrat(),$contenant_->getDuree(),$contenant_->getDateCreation(),$id_);
        $row->execute();
        $result=$row->get_result();
        if ($result->affected_rows ==1) {
            $result->close();
            return true;
        }
        $result->close();
        return false;
    }

    public function InsertData($contenant_)
    {
        $query="INSERT INTO bdd_web.posts (
                    titre, description, id_email, id_telephone, nb_de_postulations, id_entreprise, id_adresse,
                    remuneration, id_date_debut, id_date_fin, nombre_wishlist, id_contrat, id_duree, id_date_post)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";
        $row =$this->SQL->prepare($query);
        $row->bind_param("ssiiiiisiiiiii",$contenant_->getTitre(),$contenant_->getDescription(),$contenant_->getEmail(),
            $contenant_->getTelephone(),$contenant_->getNbPostulations(),$contenant_->getEntreprise(),$contenant_->getAdresse(),
            $contenant_->getRemuneration(),$contenant_->getDateDebut(),$contenant_->getDateFin(),$contenant_->getNbWhishlist(),
            $contenant_->getContrat(),$contenant_->getDuree(),$contenant_->getDateCreation());
        $row->execute();
        $result=$row->get_result();
        if ($result->affected_rows ==1) {
            $result->close();
            return true;
        }
        $result->close();
        return false;
    }

    public function getDataByID($id_)
    {
        $query="SELECT po.id as id,po.titre as titre ,po.description as description,e.email as email,t.numero as telephone,
       po.nb_de_postulations,e2.nom as entreprise,a.adresse,v.nom as ville,v.code_postal as code_postal,p.nom as pays,po.remuneration,
       d2.date as date_debut,d3.date as date_fin,po.nombre_wishlist,c.type as contrat,d.semaines as duree,d1.date as date_creation
       FROM bdd_web.posts po
         left join bdd_web.duree d on po.id_duree = d.id
         left join bdd_web.date d1 on po.id_date_post = d1.id
         left join bdd_web.date d2 on d2.id = po.id_date_debut
         left join bdd_web.date d3 on d3.id = po.id_date_fin
         left join bdd_web.email e on e.id = po.id_email
         left join bdd_web.contrat c on po.id_contrat = c.id
         left join bdd_web.telephone t on po.id_telephone = t.id
         left join bdd_web.entreprise e2 on e2.id = po.id_entreprise
         left join bdd_web.adresse a on po.id_adresse = a.id
         left join bdd_web.ville v on v.id = a.id_ville
         left join bdd_web.pays p on v.id_pays = p.id
        WHERE po.id=?";
        $result=$this->ExecuteQueryByID($query,$id_);
        $data = $result->fetch_assoc();
        $post = new Post(
                    (int)$data['id'],
                    $data['titre'],
                    $data['description'],
                    $data['date_creation'],
                    $data['email'],
                    $data['telephone'],
                    $data['adresse'],
                    $data['ville'],
                    $data['code_postal'],
                    $data['pays'],
                    (int)$data['nb_de_postulations'],
                    $data['entreprise'],
                    $data['remuneration'],
                    $data['date_debut'],
                    $data['date_fin'],
                    (int)$data['nombre_wishlist'],
                    $data['contrat'],
                    $data['duree'],
                    $this->getCompetencesByID((int)$data['id'])
                );
        $result->close();
        return $post;
    }

    public function getTrendingPosts(){
        /*
         * Récupère les offres avec le plus de postulation
         */
        $query="select posts.id,posts.titre,count(id_utilisateur) as nb
                from posts
                    left join postulation p on posts.id = p.id_post
                group by posts.id order by nb DESC LIMIT ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("i",$this->limit);
        $row->execute();
        $result=$row->get_result();
        $stat=[];
        while ($data = $result->fetch_assoc()) {
            $stat [] = ["id"=>(int)$data['id'],"titre"=> $data['titre'],"nb"=>$data['nb']];
        }
        $result->close();
        return $stat;

    }

    public function getNbCandidatureVille()
    {
        /*
         * Retourne les villes avec le plus de Candidature
         */
        $query="select v.nom as ville,count(id_utilisateur) as nb
                from posts
                         left join postulation p on posts.id = p.id_post
                            left join bdd_web.adresse a on posts.id_adresse = a.id
                            left join bdd_web.ville v on v.id = a.id_ville
                group by v.nom order by nb DESC LIMIT ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("i",$this->limit);
        $row->execute();
        $result=$row->get_result();
        $stat=[];
        while ($data = $result->fetch_assoc()) {
            $stat [] = ["ville"=>(string)$data['ville'], "nb"=>(int)$data['nb']];
        }
        $result->close();
        return $stat;
    }

    public function getMostWishPosts()
    {
        /*
         * Retourne les posts les plus bookmarrqué.
         */
        $query="select posts.id,posts.titre,count(id_utilisateur) as nb
                    from posts
                        left join whishlist w on posts.id = w.id_posts
                    group by posts.id order by nb DESC LIMIT ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("i",$this->limit);
        $row->execute();
        $result=$row->get_result();
        $stat=[];
        while ($data = $result->fetch_assoc()) {
            $stat []= ["id"=>(int)$data['id'],"titre"=> $data['titre'],"nb"=>$data['nb']];
        }
        $result->close();
        return $stat;
    }

    public function getCompetencesByID($id_)
    {
        /*
         * Retourne une chaine de carac des compétences
         */
        $query="select  competence from posts_competence
         left join competence c on c.id = id_competence
         where id_posts=?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("i",$id_);
        $row->execute();
        $result=$row->get_result();
        $competences="";
        while ($data = $result->fetch_assoc()) {
            $competences.=$data['competence']." ";
        }
        $result->close();
        return $competences;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }


    public function getPostsNew()
    {
        /*
         * Retourne (en array) les offres ajoutés récemment
         *
         */
        $query="select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille
                    ,d.date as date_post,
                       e.nom as entreprise,v.nom as ville
                FROM bdd_web.posts
                         left JOIN bdd_web.date d ON d.id = posts.id_date_post
                         left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                         left join bdd_web.adresse a on posts.id_adresse = a.id
                         left join bdd_web.ville v on a.id_ville = v.id
                order by date_post DESC LIMIT ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("i",$this->limit);
        $row->execute();
        $result=$row->get_result();
        $stat=[];
        while ($data = $result->fetch_assoc()) {
            $stat[]=
                new Post(
                    (int)$data['id'],
                    $data['titre'],
                    $data['description_pointille'],
                    "",
                    "",
                    "",
                    "",
                    $data["ville"],
                    "",
                    "",
                    "",
                    $data['entreprise'],
                    "",
                    $data['date_post'],
                    "",
                    "",
                    "",
                    "",
                    ""
                )
            ;
        }
        $result->close();
        return $stat;
    }

    public function getPostsOld()
    {
        /*
         * Retourne un array de posts considéré comme vieux ou qui expire bientot
         */
        $query="select posts.id AS id,titre, CONCAT(SUBSTRING_INDEX(description,' ',30), '...') AS description_pointille,
                d2.date as date_debut,v.nom as ville,
                   e.nom as entreprise
            FROM bdd_web.posts
                     left join bdd_web.date d2 ON d2.id = posts.id_date_debut
                     left JOIN bdd_web.entreprise e ON posts.id_entreprise = e.id
                     left join bdd_web.adresse a on posts.id_adresse = a.id
                     left join bdd_web.ville v on a.id_ville = v.id
                     
            
            order by date_debut LIMIT ?";
        $row=$this->SQL->prepare($query);
        $row->bind_param("i",$this->limit);
        $row->execute();
        $result=$row->get_result();
        $stat=[];
        while ($data = $result->fetch_assoc()) {
            $stat[]=
                new Post(
                    (int)$data['id'],
                    $data['titre'],
                    $data['description_pointille'],
                    "",
                    "",
                    "",
                    "",
                    $data["ville"],
                    "",
                    "",
                    "",
                    $data['entreprise'],
                    "",
                    $data['date_debut'],
                    "",
                    "",
                    "",
                    "",
                    ""
                )
            ;
        }
        $result->close();
        return $stat;
    }

    public function getNbpostByEntreprise($id_)
    {
        /*
         * Retourne le nombre d'offres d'une entreprise
         */
        $query="select count(*) as nb from posts where id_entreprise=?";
        $result=$this->ExecuteQueryByID($query,$id_);
        $data=$result->fetch_assoc();
        return (int)$data['nb'];
    }

    public function setLimit($limit_)
    {
        $this->limit = $limit_ >= 0 ? (int)$limit_ : $this->limit;
    }
}