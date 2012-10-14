<?php

class CComponent
{

    public function __set($name,$value)
    {
        $setter='set'.$name;
        if(method_exists($this,$setter))
            return $this->$setter($value);
        else
            $this->{$name} = $value;
    }

}
