<?php 
    $I = new AcceptanceTester($scenario);
    $I->wantTo('Check the home page for a welcome message');
    $I->amOnPage('/');
    $I->see('Welcome');
