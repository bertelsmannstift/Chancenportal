<template>
    <transition name="modal-fade">
        <div ref="modal" class="modal-backdrop" v-show="show">
            <div class="modal"
                 role="dialog"
                 aria-labelledby="modalTitle"
                 aria-describedby="modalDescription"
            >
                    <header
                        class="modal-header"
                        id="modalTitle"
                    >
                        <strong style="margin: 0 0 30px;display: block;">Unsere Nutzungsbedingungen haben sich geändert. Bitte gehen Sie ans Ende dieser Seite und klicken Sie auf „Akzeptieren“ um fortzufahren.</strong>
                        <h3 style="margin-bottom: 10px">Nutzungsbedingungen</h3>
                    </header>
                    <section class="modal-body" id="modalDescription">
                        <form action="#" method="POST" ref="form" @click="submit">
                            <slot></slot>
                            <button class="btn" :class="{'btn--loading': loading}" type="submit"><span>Akzeptieren</span></button>
                        </form>
                    </section>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: "CustomTermsAndConditions",
        props: {
            url: {
                type: String,
                default: null
            },
        },
        data: function () {
            return {
                show: true,
                loading: false,
            };
        },
        methods: {
            submit() {
                this.loading = true;
                $.ajax({
                    url: this.url,
                    method: 'POST',
                    data: $(this.$refs.form).serialize()
                }).done((data) => {
                    this.loading = false;
                    this.show = false;
                });
            }
        }
    }
</script>

<style lang="scss">
    #modalDescription {
        button {
            float: right;
            margin-top: 25px;
        }
    }
</style>
