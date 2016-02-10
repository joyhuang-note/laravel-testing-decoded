<?php

class CatTest extends TestCase {

    public function testAutomaticallyCompensatesForCatYears()
    {
        $cat = new Cat;
        $cat->age = 6;

        $this->assertEquals(42, $cat->age); // true
    }

}

?>