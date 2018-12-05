<?php

namespace App\Enum;
use Enum;

abstract class MesesEnum extends Enum {

    protected static $attributs = [
        ['id' => '01', 'descricao'  => 'Janeiro'],
        ['id' => '02', 'descricao'  => 'Fevereiro'],
        ['id' => '03', 'descricao'  => 'Março'],
        ['id' => '04', 'descricao'  => 'Abril'],
        ['id' => '05', 'descricao'  => 'Maio'],
        ['id' => '06', 'descricao'  => 'Junho'],
        ['id' => '07', 'descricao'  => 'Julho'],
        ['id' => '08', 'descricao'  => 'Agosto'],
        ['id' => '09', 'descricao'  => 'Setembro'],
        ['id' => '10', 'descricao' => 'Outubro'],
        ['id' => '11', 'descricao' => 'Novembro'],
        ['id' => '12', 'descricao' => 'Dezembro']
    ];

}

