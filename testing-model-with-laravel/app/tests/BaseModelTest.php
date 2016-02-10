<?php

class BaseModelTest extends TestCase {

    protected $model;

    public function setup()
    {
        parent::setUp();

        $this->model = $model = new BaseModel;
        $model::$rules = ['title' => 'required'];
    }

    public function testReturnsTrueIfValidationPasses()
    {
        Validator::shouldReceive('make')->once()->andReturn(
            Mockery::mock(['passes' => true])
        );

        $this->model->title = 'Foo title';
        $result = $this->model->validate();

        $this->assertEquals(true, $result);
    }

    public function testSetsErrorsOnObjectIfValidationFails()
    {
        Validator::shouldReceive('make')->once()->andReturn(
            Mockery::mock(['passes' => false, 'messages' => 'messages'])
        );

        $result = $this->model->validate();

        $this->assertEquals(false, $result);
        $this->assertEquals('messages', $this->model->errors);
    }

}

?>