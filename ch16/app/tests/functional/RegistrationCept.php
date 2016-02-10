<?php

    $I = new FunctionalTester($scenario);
    $I->wantTo('register for a new account');
    $I->lookForwardTo('be a member');

    $I->amOnPage('/register');
    $I->see('Register', 'h1');
    $I->fillField('Email:', 'joe@sample.com');
    $I->fillField('Password:', '1234');
    $I->click('Register Now');

    $I->seeCurrentUrlEquals('/login');
    $I->see('You may now sign in!', '.flash');
    $I->seeInDatabase('users', ['email' => 'joe@sample.com']);
