class Form {
    constructor(definition) {
        this._definition = definition;
    }

    setValues(values) {
        const def = this.getDefinition();

        for(let prop in def) {
            if(def.hasOwnProperty(prop) && values.hasOwnProperty(prop)) {
                def[prop].value = values[prop];
            }
        }

        return this;
    }

    getValue(name) {
        const def = this.getDefinition();

        if(def.hasOwnProperty(name)) {
            return def[name].value;
        }

        throw "Form field not defined: " + name;
    }

    getValues() {
        const result = {};
        const def = this.getDefinition();
        
        for(let prop in def) {
            if(def.hasOwnProperty(prop)) {
                result[prop] = def[prop].value;
            }
        }
        
        return result;
    }
    
    setDefinition(definition) {
        this._definition = definition;
    }

    getDefinition() {
        return this._definition ? this._definition : {};
    }

    getOptions(fieldName) {
        if(this._definition && this._definition.hasOwnProperty(fieldName) && this._definition[fieldName].hasOwnProperty('options')) {
            return this._definition[fieldName].options;
        }

        return [{option: '', label: ''}];
    }
}

export default Form;