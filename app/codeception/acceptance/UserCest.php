<?php

namespace Acceptance;

class UserCest
{
    // Execute before running each test
    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navLogin');
        $I->waitForElement('#email', 5);
        $I->fillField('#email', 'admin@example.com');
        $I->fillField('#password', 'passwd');
        $I->click('#login');
        $I->waitForElement('.navUsers', 15);
    }

    // Execute after running each test
    public function _after(\AcceptanceTester $I)
    {
    }

    public function logout(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navLogout');
        $I->waitForElement('.navLogin', 5);
    }

    public function viewUsersPageAndForms(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->click('.navUsers');
        $I->waitForElementNotVisible('#busy-overlay', 30);
        $I->click('.addUser');
        $I->waitForElement('input[aria-label="First Name"]', 15);
        $I->seeElement('input[aria-label="Last Name"]');
        $I->seeElement('input[aria-label="E-mail"]');
        $I->seeElement('input[aria-label="Role"]');
        $I->see('Create User');
        $I->click('#cancelCreate');
        $I->click('#app main table tbody tr td.layout button:nth-child(2)');
        $I->waitForElementNotVisible('#busy-overlay', 30);
        $I->seeElement('input[aria-label="First Name"]');
        $I->seeElement('input[aria-label="Last Name"]');
        $I->seeElement('input[aria-label="E-mail"]');
        $I->seeElement('input[aria-label="Role"]');
        $I->see('Edit User');
        $I->click('#cancelEdit');
        $I->click('#app main table tbody tr td.layout button:nth-child(1)');
        $I->waitForElementNotVisible('#busy-overlay', 30);
        $I->see('Delete user');
        $I->click('#cancelDelete');
        $I->click('.navLogout');
    }

    public function viewEditProfilePage(\AcceptanceTester $I)
    {
        $I->click('a[href="/profile/details"]');
        $I->waitForElementNotVisible('#busy-overlay', 30);
        $I->seeElement('input[aria-label="First Name"]');
        $I->seeElement('input[aria-label="Last Name"]');
        $I->seeElement('input[aria-label="E-mail"]');
        $I->click('.navLogout');
    }

    public function viewChangePasswordPage(\AcceptanceTester $I)
    {
        $I->click('a[href="/profile/password"]');
        $I->waitForElementNotVisible('#busy-overlay', 30);
        $I->seeElement('div.change-password .old-password');
        $I->seeElement('div.change-password .new-password');
        $I->seeElement('div.change-password .new-password-again');
        $I->click('.navLogout');
    }
}