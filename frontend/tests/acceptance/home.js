import { Selector } from 'testcafe';
import testcafeconfig from './testcafeconfig';

fixture`homepage`
    .page`${testcafeconfig.url}`;

test('View Homepage', async t => {
    await t
        .expect(Selector('div').withText('Welcome to Symlex').visible).ok();
});
