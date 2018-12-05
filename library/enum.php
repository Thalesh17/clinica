<?php

abstract class Enum {
    
    public static function where(Array $valores)
    {
        $return = [];

        if (empty($valores) || empty(static::$attributs)) {
            return false;
        }

        foreach (static::$attributs as $key => $value) {
            $exists = true;
            foreach ($valores as $skey => $svalue) {
                $exists = ($exists && IsSet(static::$attributs[$key][$skey]) && static::$attributs[$key][$skey] == $svalue);
            }

            if ($exists) {
                $return[] = static::$attributs[$key];
            }
        }
        return $return;        
    }
    
    public static function all()
    {
        return static::$attributs;
    }

    public static function find($valor, $keyId = 'id') {
        for ($i = 0; $i < count(static::$attributs); $i++) {
            if (static::$attributs[$i][$keyId] == $valor) {
                return (object) static::$attributs[$i];
            }
        }


        return '';
    }

}

