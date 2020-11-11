<template>
    <div class="clearfix">
        <h1 id="title" class="text-muted">
            <slot></slot>
        </h1>
        <nav>
            <input id="search-tpl" class="form-control mr-sm-2" type="text" placeholder="Search Templates">
        </nav>
    </div>
</template>


<script>
    export default {
        name: 'TemplateSearch',
        methods: {
            init() {
                $('#search-tpl').keyup(function () {
                    let val = $.trim($(this).val());
                    $('tbody tr').show().filter(function () {
                        let searchRegex = new RegExp(val, 'i');
                        return val !== '' && !searchRegex.test($(this).text());
                    }).hide();
                });
            }
        },
        mounted() {
            this.init();
        }
    }
</script>
