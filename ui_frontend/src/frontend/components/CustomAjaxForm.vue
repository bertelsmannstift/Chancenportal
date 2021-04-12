<template>
    <form @submit.stop :action="action" :method="method" autocomplete="off">
        <slot>No content</slot>
    </form>
</template>

<script>
    import queryString from '../mixins/query-string';

    export default {
        name: 'CustomAjaxForm',
        mixins: [queryString],
        props: {
            url: {
                default: '',
                type: String
            },
            redirectUrl: {
                default: null,
                type: String
            },
            method: {
                default: 'post',
                type: String
            },
            action: {
                default: '',
                type: String
            },
            contentSelector: {
                default: null,
                type: String
            },
            countOnSelector: {
                default: null,
                type: String
            },
            resultCountSelector: {
                default: null,
                type: String
            },
            loadingSubmitButtonClass: {
                default: 'btn--loading',
                type: String
            },
            ajax: {
                default: true,
                type: Boolean
            },
            useNative: {
                default: true,
                type: Boolean
            },
            submitAfterLoad: {
                default: false,
                type: Boolean
            },
        },
        data() {
            return {
                xhr: null,
            }
        },
        mounted() {
            this.$el.onsubmit = this.submit;

            this.handleAjaxPagination();

            if(typeof window.initTabToggle === 'function') {
                window.initTabToggle();
            }

            if(typeof window.initTogglShow === 'function') {
                window.initTogglShow();
            }

            if(((this.method.toLowerCase() === 'get' && window.location.hash.replace('#', '') !== '') || this.submitAfterLoad) && !this.queryString('nosubmit')) {
                this.$nextTick(()=>{
                    setTimeout(() => {
                        this.submit();
                    }, 1500);
                });
            } else {
                this.$nextTick(()=>{
                    setTimeout(() => {
                        if(this.method.toLowerCase() === 'get') {
                            window.location.hash = $(this.$el).serialize();
                        }
                    }, 1500);
                });
            }


        },
        created() {
            let loadFilter = this.queryString('load_filter');

            if(loadFilter === '1') {
                window.location.hash = 'load_filter=1&' + window.localStorage.getItem('filter');
            }
        },
        methods: {
            submit(event, offsets) {
                let $submitBtn = $(this.$el).find('[type=submit]');

                $submitBtn.attr('disabled', 'disabled').addClass(this.loadingSubmitButtonClass);

                if (this.ajax === false) {
                    this.action += '#' + $(this.$el).serialize() + '&nosubmit=1';
                } else {
                    if(event) {
                        event.preventDefault();
                    }
                    let loadFilter = this.queryString('load_filter');
                    let page = this.queryString('page');
                    let getData = $(this.$el).serialize();

                    if (offsets !== undefined) {
                        if (offsets.offer !== undefined) {
                            getData += '&offset=' + offsets.offer;
                        }
                        if (offsets.provider !== undefined) {
                            getData += '&offset-provider=' + offsets.provider;
                        }
                    } else {
                        getData += (page && !event ? '&page=' + page : '');
                    }

                    if(loadFilter !== '1' && this.method.toLowerCase() !== 'post') {
                        window.localStorage.removeItem('page');
                        window.localStorage.setItem('filter', getData);
                        window.location.hash = getData;
                    }

                    if(this.xhr) {
                        this.xhr.abort();
                    }

                    this.xhr = $.ajax({
                        url: this.url,
                        method: 'POST',
                        data: getData
                    }).done((data) => {
                        $submitBtn.removeAttr('disabled', 'disabled').removeClass(this.loadingSubmitButtonClass);

                        if (this.contentSelector && $(this.contentSelector).length && data.toString().length) {
                            $(this.contentSelector).html(data);

                            if(this.resultCountSelector) {
                                let resultCountSelector = JSON.parse(this.resultCountSelector);
                                let countOnSelector = JSON.parse(this.countOnSelector);
                                for(let i in resultCountSelector) {
                                    if ($(countOnSelector[i]).data('total') !== undefined) {
                                        $(resultCountSelector[i]).html($(countOnSelector[i]).data('total'));
                                    } else {
                                        $(resultCountSelector[i]).html($(countOnSelector[i]).length);
                                    }
                                }
                            }
                            if(typeof window.initTabToggle === 'function') {
                                window.initTabToggle();
                            }

                            if(typeof window.initTogglShow === 'function') {
                                window.initTogglShow();
                            }

                            setTimeout(()=>{
                                if (this.method.toLowerCase() !== 'post') {
                                    window.location.hash = getData;
                                }
                            }, 300);
                        } else if(this.redirectUrl) {
                            window.location = this.redirectUrl;
                        }
                    });
                }
            },
            handleAjaxPagination() {
                const that = this;

                $(this.$el).on('click', '.pagination a', function(e) {
                    e.preventDefault();

                    const $element = $(this);
                    const $pagination = $element.closest('.pagination');

                    let offsets = {
                        offer: $pagination.data('offsetOffer') ? $pagination.data('offsetOffer') : 0,
                        provider: $pagination.data('offsetProvider') ? $pagination.data('offsetProvider') : 0
                    };

                    if ($element.data('linktype') === 'offer') {
                        offsets.offer = $element.data('offset') !== undefined ? $element.data('offset') : offsets.offer;
                    }

                    if ($element.data('linktype') === 'provider') {
                        offsets.provider = $element.data('offset') !== undefined ? $element.data('offset') : offsets.provider;
                    }

                    $('html, body').stop().animate({
                        'scrollTop': $(that.$el).offset().top - $('.header').height()
                    }, 300);

                    that.submit(null, offsets);
                });
            }
        }
    }
</script>

<style lang="scss">
    custom-ajax-form {
        display: block;
    }
</style>
