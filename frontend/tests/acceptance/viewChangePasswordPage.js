import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';
import Page from "./page-model";

fixture`change password page`
    .page`${testcafeconfig.url}`;

const page = new Page();

test('View change password page', async t => {
    await page.openNav();
    await page.login();
    await page.openNav();
    await t
        .click(Selector('a[href="/profile/password"]'))
        .expect(Selector('.old-password').visible).ok()
        .expect(Selector('.new-password').visible).ok()
        .expect(Selector('.new-password-again').visible).ok()
        .expect(Selector('div').withText('Change your password').visible).ok()
});
