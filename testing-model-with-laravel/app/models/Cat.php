<?php

class Cat extends Eloquent {

    public function setAgeAttribute($age)
    {
        $this->attributes['age'] = $age * 7;
    }

}

?>