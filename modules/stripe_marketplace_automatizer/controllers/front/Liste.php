<?php

require_once __DIR__."/../../../../config/config.inc.php";


class Liste
{
    private $db;
    private $conf;

    public function __construct(){

        $this->db = \Db::getInstance();

        // Logger::log("WebHookStripe::__contruct", [
        //     'seller' => $this->getAllSeller(),
        // ], $this->uid);
    }

    public function all()
    {
        return str_replace("'", " ", json_encode($this->getAllSeller()));
    }

    private function getAllSeller($exist_sma_acct = false)
    {
        $request = "select u1.id_seller, u3.firstname, u3.lastname from " . _DB_PREFIX_ . "kb_mp_seller u1 LEFT JOIN " . _DB_PREFIX_ . "customer u3 ON u1.id_customer = u3.id_customer";
        if(! $exist_sma_acct)
        {
            $request .= " where not exists (select id_seller  from " . _DB_PREFIX_ . "sma_seller_acct u2 where u1.id_seller=u2.id_seller)";
        }
        return $this->db->executeS($request);
    }
}


// new Liste();
// die;