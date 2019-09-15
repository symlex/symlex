import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';
import Page from "./page-model";

fixture`edit profile page`
    .page`${testcafeconfig.url}`;

const page = new Page();

test('View edit profile page', async t => {
    await page.openNav();
    await page.login();
    await page.openNav();
    await t
        .click(Selector('a[href="/profile/details"]'))
        .expect(Selector('input[aria-label="First Name"]').value).eql('Admin')
        .expect(Selector('input[aria-label="Last Name"]').value).eql('Example')
        .expect(Selector('input[aria-label="E-mail"]').value).eql('admin@example.com')
        .expect(Selector('div').withText('Change your personal details').visible).ok()
});
