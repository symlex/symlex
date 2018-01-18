<?php

namespace Acceptance;

class HomeCest
{
    // Execute before running each test
    public function _before(\AcceptanceTester $I)
    {
    }

    // Execute after running each test
    public function _after(\AcceptanceTester $I)
    {
    }

    public function openHomepage(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Symlex');
    }
}