import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';
import Page from "./page-model";

fixture`login`
    .page`${testcafeconfig.url}`;

const page = new Page();

test('Login', async t => {
    await page.openNav();
    await t
        .expect(Selector('.navUsers').exists).notOk();
    await page.login();
    await page.openNav();
    await t
        .expect(Selector('.navUsers').visible).ok()
        .expect(Selector('.navLogin').exists).notOk();
});
