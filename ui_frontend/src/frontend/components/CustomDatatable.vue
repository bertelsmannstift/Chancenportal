<template>
    <div class="custom-datatable">
        <div :style="{'visibility': loading ? 'hidden' : 'visible'}">
            <slot></slot>
        </div>
        <custom-pagination show="true" items-per-page="20" js-pagination="tbody"></custom-pagination>
    </div>
</template>

<script>
    import queryString from '../mixins/query-string';

    export default {
        mixins: [queryString],
        props: {
            sorting: {
                type: Array,
                default: () => []
            },
            searchInputSelector: {
                type: String,
                default: null
            },
            sortBy: {
                type: Number,
                default: null
            }
        },
        data() {
            return {
                loading: false
            }
        },
        watch: {
            sortBy(sortIndex) {
                if (sortIndex && sortIndex.toString().trim().length) {
                    $(this.$el).find('thead th').eq(sortIndex).click();
                }
            }
        },
        methods: {
            filter(val) {

                if (val.toString().trim() === '') {
                    $('custom-pagination').attr('show', 'true');
                } else {
                    $('custom-pagination').attr('show', 'false');
                }

                $(this.$el).find('tbody tr').each((key, tr) => {
                    const searchRegex = new RegExp(val, 'i');
                    if (searchRegex.test($(tr).text())) {
                        $(tr).show();
                    } else {
                        $(tr).hide();
                    }
                });
            }
        },
        mounted() {
            let $table = $(this.$el).find('table:first');
            let $tbody = $table.find('tbody');
            let $tbodyInitial = $table.find('tbody').html();

            const renameTag = function ($obj, new_tag) {
                let obj = $obj.get(0);
                let tag = obj.tagName.toLowerCase();
                let tag_start = new RegExp('^<' + tag);
                let tag_end = new RegExp('<\\/' + tag + '>$');
                let new_html = obj.outerHTML.replace(tag_start, "<" + new_tag).replace(tag_end, '</' + new_tag + '>');
                $obj.replaceWith($(new_html));
            };

            let sorting = JSON.parse(this.sorting);

            sorting.forEach((item) => {
                let that = this;
                $(this.$el).find('thead th').eq(item.col).addClass('custom-datatable__sortable').click(function (e) {
                    e.preventDefault();
                    that.loading = true;
                    that.$forceUpdate();

                    $('custom-pagination').attr('show', 'false');

                    setTimeout(() => {

                        $(this).siblings().removeClass('custom-datatable__sortable--desc custom-datatable__sortable--asc');

                        if (typeof $(this).data('sort') === 'undefined') {
                            $(this).data('sort', 0);
                        }

                        if ($(this).data('sort') === 1) {
                            $(this).removeClass('custom-datatable__sortable--desc').addClass('custom-datatable__sortable--asc').data('sort', -1);
                        } else if ($(this).data('sort') === -1) {
                            $(this).removeClass('custom-datatable__sortable--desc custom-datatable__sortable--asc').data('sort', 0);
                        } else {
                            $(this).data('sort', 1).removeClass('custom-datatable__sortable--asc').addClass('custom-datatable__sortable--desc');
                        }

                        if ($(this).data('sort') === 0) {
                            $tbody.html($tbodyInitial);
                        } else {

                            let isDate = new RegExp('\\d{2}\\.\\d{2}\\.\\d{4}');
                            let isNumber = new RegExp('^\\d*$');

                            let $tr = $tbody.find('tr').sort((a, b) => {

                                let tda = $(a).find('td').eq(item.col).text().trim().toLowerCase();
                                let tdb = $(b).find('td').eq(item.col).text().trim().toLowerCase();

                                if (tda !== '' && isNumber.test(tda)) {
                                    tda = parseInt(tda);
                                }

                                if (tdb !== '' && isNumber.test(tdb)) {
                                    tdb = parseInt(tdb);
                                }

                                if (isDate.test(tda) && isDate.test(tdb)) {
                                    tda = tda.split('.');
                                    tda = tda.reverse();
                                    tda = tda.join('-');

                                    tdb = tdb.split('.');
                                    tdb = tdb.reverse();
                                    tdb = tdb.join('-');
                                }

                                return tda < tdb ? parseInt($(this).data('sort')) : (tda > tdb ? parseInt($(this).data('sort')) * -1 : 0);
                            });

                            $tbody.html($tr);
                        }

                        $('custom-confirm[vce-ready]').remove();

                        $('.custom-confirm').each(function () {
                            $(this).show();
                            $(this).clone().hide().insertAfter($(this));
                            renameTag($(this), 'custom-confirm');
                        });

                        $('custom-pagination').attr('show', 'true');
                        that.loading = false;
                        that.$forceUpdate();
                    });
                });
            });

            if (this.searchInputSelector) {
                $(this.searchInputSelector).keyup(() => {
                    this.filter($(this.searchInputSelector).val());
                });
            }

            $('.custom-confirm').each(function () {
                $(this).clone().hide().insertAfter($(this));
                renameTag($(this), 'custom-confirm');
            });

            if (window.location.hash !== '') {
                let initSort = this.queryString('sort');
                $(this.$el).find('thead th').eq(initSort).click();
            }
        },
        name: 'CustomDatatable'
    }
</script>
