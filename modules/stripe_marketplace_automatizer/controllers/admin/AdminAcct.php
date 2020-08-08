<?php

require_once _PS_MODULE_DIR_ . '/stripe_marketplace_automatizer/classes/Acct.php';
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";


class AdminAcctController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true; //Gestion de l'affichage en mode bootstrap 
        $this->table = Acct::$definition['table']; //Table de l'objet
        $this->identifier = Acct::$definition['primary']; //Clé primaire de l'objet
        $this->className = Acct::class; //Classe de l'objet
        $this->lang = false; //Flag pour dire si utilisation de langues ou non
 
        //Appel de la fonction parente pour pouvoir utiliser la traduction ensuite
        parent::__construct();

        $this->_select = 'a.id_acct as `acctID`, sl.id_seller as `sellerID`, cs.firstname as `nom`, cs.lastname as `prenom`';
        $this->_join = '
            RIGHT JOIN `'._DB_PREFIX_.'kb_mp_seller` sl ON (sl.id_seller=a.id_seller) 
            LEFT JOIN `'._DB_PREFIX_.'customer` cs ON (sl.id_customer=cs.id_customer)
        ';
        $this->fields_list = [
        //'id' => ['title' => 'ID','class' => 'fixed-width-xs'],
        'sellerID' => ['title' => 'ID Seller', 'filter_key'=>'sl!id_seller'], // filter_key mandatory because "name" is ambiguous for SQL
        'prenom' => ['title' => 'Prénom', 'filter_key'=>'cs!lastname'], // filter_key mandatory because JOIN
        'nom' => ['title' => 'Nom', 'filter_key'=>'cs!firstname'], // filter_key mandatory because JOIN
        'acctID' => ['title' => 'ID compte stripe', 'filter_key'=>'a!id_acct'], // filter_key mandatory because JOIN
        ];
 
        //Liste des champs de l'objet à afficher dans la liste
        // $this->fields_list = [
        //     'id_seller' => [ //nom du champ sql
        //         'title' => $this->module->l('ID'), //Titre
        //         'align' => 'center', // Alignement
        //         'class' => 'fixed-width-xs' //classe css de l'élément
        //     ],
        //     'id_acct' => [
        //         'title' => $this->module->l('ID Compte stripe'),
        //         'align' => 'left',
        //     ]
        // ];
 
        //Ajout d'actions sur chaque ligne
        $this->addRowAction('edit');
    }


    /**
     * Affichage du formulaire d'ajout / création de l'objet
     * @return string
     * @throws SmartyException
     */
    public function renderForm()
    {
        //Définition du formulaire d'édition
        $this->fields_form = [
            //Entête
            'legend' => [
                'title' => $this->module->l('Modifier un compte vendeur'),
                'icon' => 'icon-cog'
            ],
            //Champs
            'input' => [
                [
                    'type' => 'text', //Type de champ
                    'label' => 'ID Compte stripe', //Label
                    'name' => 'id_acct', //Nom
                    'class' => 'input fixed-width-sm', //classes css
                    'size' => 255, //longueur maximale du champ
                    'required' => true, //Requis ou non
                    'empty_message' => $this->l('S\'il vous plaît remplir'), //Message d'erreur si vide
                ],
            ],
            //Boutton de soumission
            'submit' => [
                'title' => 'Enregistrer', //On garde volontairement la traduction de l'admin par défaut
            ]
        ];
        return parent::renderForm();
    }
}