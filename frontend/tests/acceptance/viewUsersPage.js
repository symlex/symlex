import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';
import Page from "./page-model";

fixture`user page`
    .page`${testcafeconfig.url}`;

const page = new Page();

test('View user page', async t => {
    await page.openNav();
    await page.login();
    await page.openNav();
    await t
        .click('.navUsers')
        .expect(Selector('td').withText('admin@example.com').visible).ok()
        .expect(Selector('td').withText('user@example.com').visible).ok()
        .click('.addUser')
        .expect(Selector('div').withText('First Name').visible).ok()
        .expect(Selector('label').withText('Last Name').visible).ok()
        .expect(Selector('label').withText('E-mail').visible).ok()
        .expect(Selector('label').withText('Role').visible).ok()
        .expect(Selector('div').withText('Create User').visible).ok()
        .click('#cancelCreate')
        .click(Selector('#app main table tbody tr td.layout button').nth(1))
        .expect(Selector('div').withText('Admin')).ok()
        .expect(Selector('div').withText('Example').visible).ok()
        .expect(Selector('div').withText('admin@example.com').visible).ok()
        .expect(Selector('div').withText('Edit User').visible).ok()
        .click('#cancelEdit')
        .click(Selector('#app main table tbody tr td.layout button').nth(2))
        .expect(Selector('div').withText('Delete User').visible).ok()
        .click('#cancelDelete')
        .expect(Selector('td').withText('admin@example.com').visible).ok()
        .expect(Selector('td').withText('user@example.com').visible).ok();
});
