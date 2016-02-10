<?php

class PracticeTest extends TestCase {

    public function testBuildsAnchorTag()
    {
        $actual = link_to_by_custom('/dogs/1', 'Show Dog'); // which is defined in app/helpers.php
        $expect = "<a href='http://localhost/dogs/1'>Show Dog</a>";

        $this->assertEquals($expect, $actual);
    }

    public function testAppliesAttributesUsingArry()
    {
        $actual = link_to_by_custom('/dogs/1', 'Show Dog', ['class' => 'button']);
        $expect = "<a href='http://localhost/dogs/1' class=\"button\">Show Dog</a>";

        $this->assertEquals($expect, $actual);
    }

}

?>