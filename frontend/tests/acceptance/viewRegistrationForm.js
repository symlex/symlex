import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';
import Page from "./page-model";

fixture`registration form`
    .page`${testcafeconfig.url}`;

const page = new Page();

test('View Registration form', async t => {
    await page.openNav();
    await t
        .click(Selector('.navRegister'))
        .expect(Selector('label').withText('First Name').visible).ok()
        .expect(Selector('label').withText('Last Name').visible).ok()
        .expect(Selector('label').withText('E-mail').visible).ok()
        .expect(Selector('label').withText('Captcha Phrase').visible).ok();
});
