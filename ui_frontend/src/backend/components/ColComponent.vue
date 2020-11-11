<script>
    export default {
        name: 'ColComponent',
        functional: true,
        render: (h, {props, data, children}) => {
            if (data.attrs) {
                let classes = Object.keys(data.attrs).map((v) => {
                    return (v.match(/(xs|s|sm|md|lg|xl)-/) ? 'col-' : '') + v;
                });

                data.attrs = {'class': classes.join(' ')}
            } else {
                data.attrs = {'class': 'col-lg-12'}
            }

            return h('div', data, children);
        }
    }
</script>
