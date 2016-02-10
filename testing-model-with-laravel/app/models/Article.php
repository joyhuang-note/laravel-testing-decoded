<?php

class Article extends Eloquent {

    public function meta()
    {
        return sprintf('"%s" was written by %s',
                        $this->title,
                        $this->author);
    }

}

?>