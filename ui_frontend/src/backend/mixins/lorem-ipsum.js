const loremIpsumLib = require('lorem-ipsum');
module.exports = {
    methods: {
        loremIpsum(words) {
            return loremIpsumLib({
                count: words,
                units: 'word'
            });
        },
        sentence(count, lower, upper) {
            return loremIpsumLib({
                count: count||1,
                units: 'sentences',
                sentenceLowerBound: lower||60,
                sentenceUpperBound: upper||100
            });
        }
    }
};
