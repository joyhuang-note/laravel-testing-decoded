<?php

class Author extends BaseModel {

    public static $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:authors'
    ];

}

?>