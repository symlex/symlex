import Abstract from "model/abstract";
import Form from "common/form";
import Api from "common/api";

class Registration extends Abstract {
    getEntityName() {
        return this.userFirstName + " " + this.userLastName;
    }

    getId() {
        return this.userId;
    }

    sendConfirmForm(token, form) {
        return Api.put(this.getEntityResource(token), form.getValues()).then((response) => Promise.resolve(this.setValues(response.data)));
    }

    getConfirmForm(token) {
        return Api.options(this.getEntityResource(token)).then(response => Promise.resolve(new Form(response.data)));
    }

    static getCollectionResource() {
        return "registration";
    }

    static getModelName() {
        return "Registration";
    }
}

export default Registration;
