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
        $I->see('Welcome to Symlex');
    }

    public function login(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navLogin');
        $I->waitForElement('#email', 5);
        $I->fillField('#email', 'admin@example.com');
        $I->fillField('#password', 'passwd');
        $I->click('#login');
        $I->waitForElement('.navUsers', 15);
        $I->click('.navLogout');
        $I->waitForElement('.navLogin', 10);
    }

    public function viewRegisterForm(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navRegister');
        $I->waitForText('First Name', 5);
        $I->see('Last Name');
        $I->see('E-Mail');
        $I->see('Captcha');
        $I->see('SIGN UP');
    }

    public function checkLinksOnWelcomePage(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('kernel');
        $I->switchToNextTab();
        $I->see('A micro-kernel based on the Symfony service');
        $I->amOnPage('/');
        $I->click('Visit this project on GitHub');
        $I->switchToNextTab();
        $I->see('framework stack for agile Web development');
        $I->amOnPage('/');
        $I->click('Open Documentation');
        $I->switchToNextTab();
        $I->see('Symlex is designed to be simple with few concepts to understand');
        $I->amOnPage('/');
        $I->click('See Contributors');
        $I->switchToNextTab();
        $I->see('Contributions to master, excluding merge commits');
        $I->amOnPage('/');
    }


}