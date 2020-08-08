<?php

class Acct extends ObjectModel
{
    public $id;
    public $id_seller;
    public $id_acct;
 
    public static $definition = [
        'table' => 'sma_seller_acct',
        'primary' => 'id',
        'multilang' => false,
        'fields' => [
            // Champs Standards
            'id_seller' => ['type' => self::TYPE_INT, 'size' => 11, 'required' => true],
            'id_acct' => ['type' => self::TYPE_STRING, 'size' => 255, 'required' => false],
            // 'email' => ['type' => self::TYPE_STRING, 'validate' => 'isEmail', 'size' => 255, 'required' => true],
            //Champs langue
            // 'title' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml', 'size' => 255,],
            // 'description' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml',],
        ],
    ];
}