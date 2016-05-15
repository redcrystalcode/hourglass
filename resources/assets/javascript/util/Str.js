import camelCase from 'camelcase';

class Str {
    static capitalize(str) {
        return str.charAt(0).toUpperCase() + str.substr(1);
    }
    static camelCase(str) {
        return camelCase(str);
    }
    static upperCamelCase(str) {
        return Str.capitalize(
            Str.camelCase(str)
        );
    }
}

export default Str;
