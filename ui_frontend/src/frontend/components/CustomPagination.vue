<template>
    <div v-if="show" class="pagination" :class="containerClass">
        <a v-if="pageCount > 1 && !firstPageSelected() && !hidePrevNext" href="#" @click.prevent.stop="prevPage()"
           @keyup.enter="prevPage()" :class="[prevLinkClass, firstPageSelected() ? disabledClass : '']" tabindex="0">
            <slot name="prevContent"><i class="icon-chevron-left"></i></slot>
        </a>
        <template v-if="pageCount > 1" v-for="page in pages">
            <a v-if="page.breakView" :class="[breakViewLinkClass, page.disabled ? disabledClass : '']" tabindex="0">
                <slot name="breakViewContent">{{ breakViewText }}</slot>
            </a>
            <a v-else-if="page.disabled" :class="[pageLinkClass, page.selected ? activeClass : '', disabledClass]"
               tabindex="0">{{ page.content }}</a>
            <a v-else href="#" @click.prevent.stop="handlePageSelected(page.index)"
               @keyup.enter="handlePageSelected(page.index)" :class="[pageLinkClass, page.selected ? activeClass : '']"
               tabindex="0">{{ page.content }}</a>
        </template>
        <a v-if="lastPageSelected() && !hidePrevNext" href="#" @click.prevent.stop="nextPage()"
           @keyup.enter="nextPage()" :class="[nextLinkClass, lastPageSelected() ? disabledClass : '']" tabindex="0">
            <slot name="nextContent"><i class="icon-chevron-right"></i></slot>
        </a>
    </div>
</template>

<script>
    import queryString from '../mixins/query-string';

    export default {
        mixins: [queryString],
        name: 'CustomPagination',
        props: {
            show: {
                type: Boolean,
                default: true
            },
            initialPage: {
                type: Number,
                default: 0
            },
            forcePage: {
                type: Number
            },
            pageRange: {
                type: Number,
                default: 3
            },
            marginPages: {
                type: Number,
                default: 1
            },
            id: {
                type: String,
                default: 'page'
            },
            formSelector: {
                type: String,
                default: 'custom-ajax-form'
            },
            breakViewText: {
                type: String,
                default: '...'
            },
            containerClass: {
                type: String
            },
            pageClass: {
                type: String
            },
            pageLinkClass: {
                type: String,
                default: 'pagination__page'
            },
            prevClass: {
                type: String,
                default: 'pagination__back'
            },
            prevLinkClass: {
                type: String,
                default: 'pagination__prev'
            },
            nextClass: {
                type: String
            },
            nextLinkClass: {
                type: String,
                default: 'pagination__for'
            },
            breakViewClass: {
                type: String,
                default: 'pagination__dot'
            },
            breakViewLinkClass: {
                type: String
            },
            activeClass: {
                type: String,
                default: 'pagination__page--current'
            },
            disabledClass: {
                type: String,
                default: 'pagination__disabled'
            },
            hidePrevNext: {
                type: Boolean,
                default: false
            },
            jsPagination: {
                type: String,
                default: null
            },
            itemsPerPage: {
                type: Number,
                default: 10
            }
        },
        data() {
            return {
                selected: this.initialPage,
                allItems: [],
                pageCount: {
                    type: Number
                },
            }
        },
        watch: {
            selected(val) {
                window.localStorage.setItem('page', val);
            },
            show(val) {
                if(val) {
                    this.toggleItems();
                } else {
                    this.allItems.show();
                }
            }
        },
        beforeUpdate() {
            if (this.forcePage === undefined) return
            if (this.forcePage !== this.selected) {
                this.selected = this.forcePage
            }
        },
        computed: {
            pages: function () {
                let items = {}
                if (this.pageCount <= this.pageRange) {
                    for (let index = 0; index < this.pageCount; index++) {
                        let page = {
                            index: index,
                            content: index + 1,
                            selected: index === this.selected
                        }
                        items[index] = page
                    }
                } else {
                    const halfPageRange = Math.floor(this.pageRange / 2)

                    let setPageItem = index => {
                        let page = {
                            index: index,
                            content: index + 1,
                            selected: index === this.selected
                        }

                        items[index] = page
                    }

                    let setBreakView = index => {
                        let breakView = {
                            disabled: true,
                            breakView: true
                        }

                        items[index] = breakView
                    }

                    // 1st - loop thru low end of margin pages
                    for (let i = 0; i < this.marginPages; i++) {
                        setPageItem(i);
                    }

                    // 2nd - loop thru selected range
                    let selectedRangeLow = 0;
                    if (this.selected - halfPageRange > 0) {
                        selectedRangeLow = this.selected - halfPageRange;
                    }

                    let selectedRangeHigh = selectedRangeLow + this.pageRange - 1;
                    if (selectedRangeHigh >= this.pageCount) {
                        selectedRangeHigh = this.pageCount - 1;
                        selectedRangeLow = selectedRangeHigh - this.pageRange + 1;
                    }

                    for (let i = selectedRangeLow; i <= selectedRangeHigh && i <= this.pageCount - 1; i++) {
                        setPageItem(i);
                    }

                    // Check if there is breakView in the left of selected range
                    if (selectedRangeLow > this.marginPages) {
                        setBreakView(selectedRangeLow - 1)
                    }

                    // Check if there is breakView in the right of selected range
                    if (selectedRangeHigh + 1 < this.pageCount - this.marginPages) {
                        setBreakView(selectedRangeHigh + 1)
                    }

                    // 3rd - loop thru high end of margin pages
                    for (let i = this.pageCount - 1; i >= this.pageCount - this.marginPages; i--) {
                        setPageItem(i);
                    }
                }
                return items
            }
        },
        mounted() {
            if (window.location.hash !== '') {
                let page = this.queryString(this.id);
                if (page) {
                    this.selected = parseInt(page) - 1;
                }
            }

            this.$nextTick(() => {
                if (this.jsPagination) {
                    this.allItems = $(this.jsPagination).children();
                    this.pageCount = Math.ceil(this.allItems.length / this.itemsPerPage);
                    this.toggleItems();
                }
            });

            let p = window.localStorage.getItem('page');
            let loadFilter = this.queryString('load_filter');

            this.$nextTick(() => {
                if (p && loadFilter === '1') {
                    this.handlePageSelected(parseInt(p));
                } else {
                    let page = this.queryString('page') ? this.queryString('page') : 0;
                    this.handlePageSelected(parseInt(page));
                }
            });
        },
        methods: {
            toggleItems() {
                if (this.jsPagination) {
                    this.allItems = $(this.jsPagination).children();
                    this.allItems.show();
                    if (this.allItems.length > this.itemsPerPage) {
                        let idxStart = ((this.selected + 1) * this.itemsPerPage) - this.itemsPerPage;
                        let idxEnd = ((this.selected + 1) * this.itemsPerPage);
                        this.allItems.hide();
                        this.allItems.slice(idxStart, idxEnd).show();
                    }
                }
            },
            changePage(page) {
                let $form = $(this.formSelector);
                let $hiddenField = $form.find('[name="' + this.id + '"]');
                if ($hiddenField.length === 0) {
                    $hiddenField = $('<input type="hidden"/>').attr('name', this.id).appendTo($form);
                }
                $hiddenField.val(page);

                if (this.jsPagination) {
                    this.toggleItems();
                    $('html, body').stop().animate({
                        'scrollTop': $(this.jsPagination).offset().top - $('.header').height()
                    }, 300);
                } else {
                    $form.submit();
                }
            },
            handlePageSelected(selected) {

                if(selected > this.pageCount) {
                    this.handlePageSelected(0);
                    return;
                }

                if (this.selected === selected) return

                this.selected = selected;

                this.updateQueryString('page', selected);

                this.changePage(this.selected + 1);
            },
            prevPage() {
                if (this.selected <= 0) return

                this.selected--

                this.changePage(this.selected + 1)
            },
            nextPage() {
                if (this.selected >= this.pageCount - 1) return

                this.selected++

                this.changePage(this.selected + 1)
            },
            firstPageSelected() {
                return this.selected === 0
            },
            lastPageSelected() {
                return (this.selected + 1 < this.pageCount)
            }
        }
    }
</script>

<style lang="scss">
    .pagination {
        text-align: center;
        margin: 40px 0 0 0;
        .pagination__dot, .pagination__page {
            color: $color-gray-dark
        }
        .pagination__page--current {
            color: $color-black;
        }
        > a, span {
            display: inline-block;
            padding: 0 12px;
            outline: none;
            cursor: pointer;
        }
        .pagination__prev,
        .pagination__for {
            font-size: 14px;
        }
    }
</style>
