<?php

class ArticleTest extends TestCase {

    public function testGetsReadableMetaData()
    {
        $article = new Article;
        $article->title = 'My first Article';
        $article->author = 'Huang Yu Kai';

        $this->assertEquals('"My first Article" was written by Huang Yu Kai',
                            $article->meta());
    }

}


?>