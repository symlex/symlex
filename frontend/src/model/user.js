import Abstract from 'model/abstract';
import Form from 'common/form';
import Api from 'common/api';

class User extends Abstract {
    getEntityName() {
        return this.userFirstName + ' ' + this.userLastName;
    }

    getId() {
        return this.userId;
    }

    getProfileForm() {
        return Api.options(this.getEntityResource() + '/profile').then(response => Promise.resolve(new Form(response.data)));
    }

    saveProfile() {
        console.log('saveProfile', this.getValues());
        return Api.post(this.getEntityResource() + '/profile', this.getValues()).then((response) => Promise.resolve(this.setValues(response.data)));
    }

    static getCollectionResource() {
        return 'users';
    }

    static getModelName() {
        return 'User';
    }
}

export default User;