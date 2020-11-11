const queryString = require('query-string');

module.exports = {
    methods: {
        queryString(name) {
            const parsed = queryString.parse(window.location.hash);
            return parsed[name] ? parsed[name] : null;
        },
        updateQueryString(name, value) {
            const parsed = queryString.parse(window.location.hash);
            parsed[name] = value;
            window.location.hash = queryString.stringify(parsed);
            return window.location.hash;
        }
    }
};
