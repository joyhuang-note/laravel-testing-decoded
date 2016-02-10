<?php

class CustomGenerator {

    protected $file;

    public function __construct(File $file = null)
    {
        $this->file = $file ?: new File;
    }

    protected function getContent()
    {
        return 'foo bar';
    }

    public function fire()
    {
        $content = $this->getContent();
        $file = 'foo.txt';

        if (!$this->file->exists($file))
        {
            $this->file->put($file, $content);
        }
    }

}

?>