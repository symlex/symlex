import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';
import Page from "./page-model";

fixture`logout`
    .page`${testcafeconfig.url}`;

const page = new Page();

test('Logout', async t => {
    await page.openNav();
    await t
        .expect(Selector('.navUsers').exists).notOk();
    await page.login();
    await page.openNav();
    await t
        .click(Selector('.navLogout'));
    await page.openNav();
    await t
        .expect(Selector('.navLogin').visible).ok();
});
