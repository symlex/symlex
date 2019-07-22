import {Selector, t} from 'testcafe';

export default class Page {
    constructor() {
    }

    async login() {
        await t
        .click(Selector('.navLogin'))
        .typeText('#email',  'admin@example.com')
        .typeText('#password',  'passwd')
        .click('#login');
    }

    async openNav() {
        if (await Selector('button.v-toolbar__side-icon').visible) {
            await t
                .click(Selector('button.v-toolbar__side-icon'));

        }
    }
}
