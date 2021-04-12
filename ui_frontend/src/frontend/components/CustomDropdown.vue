<template>
    <div>
        <div ref="dropdown"
             :required="required"
             class="custom-dropdown input__dropdown"
             :class="[{'custom-dropdown--disabled': isElmDisabled,'custom-dropdown--normal': showSelectedTitle && !multipleSelect, 'custom-dropdown--multiple': multipleSelect, 'custom-dropdown--open': isOpen, 'custom-dropdown--filter-active': activeItems.length}, (theme ? 'custom-dropdown--' + theme : '')]">

            <button type="button" ref="btn" @click.stop.prevent="toggleDropdown()"
                    :title="(placeholder ? placeholder + ': ' : '') + currentSelection"
                    :aria-expanded="isOpen ? 'true' : 'false'"
                    class="custom-dropdown__placeholder">{{currentSelection}}
            </button>

            <div v-show="isOpen" class="custom-dropdown__layer">
                <template v-if="loaded && $slots.default">
                    <slot name="default"></slot>
                </template>
                <template v-if="loaded && !$slots.default">
                    <ul ref="list" class="custom-dropdown__items" :aria-hidden="!isOpen" :id="'collapsible-'+placeholder">
                        <li v-for="item in items" class="custom-dropdown__item"
                            :class="{'custom-dropdown__item--active': item.active}">

                            <div v-if="allowGroupSelection === false && (item.items && item.items.length)" tabindex="0" class="custom-dropdown__group">
                                <span>{{item.title}}</span>
                            </div>

                            <template v-else>
                                <a v-if="allowGroupSelection === true || (item.items && item.items.length)" href="#" @click.prevent.stop="itemClick(item, $event)" tabindex="0" :class="{'custom-dropdown__link--disabled': item.disabled, 'custom-dropdown__item-link--active': item.active && !multipleSelect}"
                                   class="custom-dropdown__link custom-dropdown__group">
                                    <span>{{item.title}}</span>
                                </a>

                                <a v-else href="#" class="custom-dropdown__link" :class="{'custom-dropdown__link--disabled': item.disabled}" @click.prevent.stop="itemClick(item, $event)"
                                   tabindex="0"><span>{{item.title}}</span></a>
                            </template>

                            <div v-if="item.items && item.items.length" class="custom-dropdown__groupitems">
                                <div v-for="item in item.items" class="custom-dropdown__item"
                                     :class="{'custom-dropdown__item--active': item.active}">
                                    <a href="#" class="custom-dropdown__link" :class="{'custom-dropdown__link--disabled': item.disabled, 'custom-dropdown__item-link--active': item.active && !multipleSelect}"
                                       @click.prevent.stop="toggleActive(item, $event)"
                                       tabindex="0"><span>{{item.title}}</span></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </template>

            </div>
            <input type="text" class="custom-dropdown__hidden" autocomplete="new-password" :name="id + (multipleSelect ? '[]' : '')" value="" v-if="required && hiddenFields.length === 0" required="required" />
        </div>

        <div v-for="sName in dynamicSlots" v-if="activeItems.length && activeItems[0].id.toString() === sName.toString()" class="custom-dropdown__toggle_content">
            <slot :name="sName"></slot>
        </div>
    </div>
</template>

<script>
    import queryString from '../mixins/query-string';

    export default {
        mixins: [queryString],
        props: {
            options: {
                default: '',
                type: String
            },
            value: {
                default: null,
                type: String
            },
            allowGroupSelection: {
                default: true,
                type: Boolean
            },
            isDisabled: {
                default: false,
                type: Boolean
            },
            placeholder: {
                default: '',
                type: String
            },
            buttonText: {
                default: 'Übernehmen',
                type: String
            },
            formSelector: {
                default: '',
                type: String
            },
            id: {
                default: 'id',
                type: String
            },
            theme: {
                default: null,
                type: String
            },
            multipleSelect: {
                default: false,
                type: Boolean
            },
            allowOnlyOneGroupSelect: {
                default: true,
                type: Boolean
            },
            disableToggle: {
                default: true,
                type: Boolean
            },
            showSelectedTitle: {
                default: true,
                type: Boolean
            },
            required: Boolean,
            showTag: {
                default: false,
                type: Boolean
            },
            submitOnChange: {
                default: false,
                type: Boolean
            },
            emptyToggleSelector: {
                default: null,
                type: String
            },
            sameValue: {
                default: null,
                type: String
            }
        },
        data() {
            return {
                dynamicSlots: [],
                items: [],
                currentSelection: '',
                isOpen: false,
                loaded: false,
                isElmDisabled: false,
                initiated: false,
                noSubcategories: true,
                activeItems: [],
                hiddenFields: []
            }
        },
        watch: {
            isOpen(val) {
                if (!val) {
                    this.$emit('select', this.activeItems);

                    if(this.showTag) {
                        $('custom-active-filter').trigger('add', [{
                            detail: {
                                id: this.id,
                                onClear: this.toggleActive,
                                items: this.activeItems
                            }
                        }]);
                    }
                }
            },
            isDisabled(val) {
                this.isElmDisabled = val;
            },
            value() {
                let items = this.options ? JSON.parse(this.options) : [];
                if (items.length) {
                    this.items = this.initItems(items);
                }
            },
            activeItems() {
                for (let i in this.hiddenFields) {
                    if (this.hiddenFields[i]) {
                        this.hiddenFields[i].parentNode.removeChild(this.hiddenFields[i]);
                    }
                }

                this.hiddenFields = [];
                let $form = null;

                if (this.formSelector !== '') {
                    $form = $(this.formSelector);
                }

                for (let i in this.activeItems) {
                    let item = this.activeItems[i];
                    if(item.id.toString().trim() !== '') {
                        let hiddenField = document.createElement('input');
                        hiddenField.setAttribute('type', 'hidden');
                        hiddenField.setAttribute('value', item.id);
                        hiddenField.setAttribute('name', this.id + (this.multipleSelect ? '[]' : ''));
                        $(this.$parent.$el.parentElement).prepend(hiddenField);
                        this.hiddenFields.push(hiddenField);

                        if ($form) {
                            $(hiddenField).appendTo($form);
                        }
                    }
                }
            }
        },
        methods: {

            /**
             * Toggle Dropdown open/close
             */
            toggleDropdown(event) {
                if(this.isElmDisabled) {
                    return;
                }
                let beforeAllClose = this.isOpen;
                document.body.click();
                this.isOpen = !beforeAllClose;
            },
            /**
             * Recursive deaktivate all items
             * @param items
             */
            deactivateItems(items) {
                for (let i in items) {
                    items[i].active = false;
                    if (items[i].items && items[i].items.length) {
                        this.deactivateItems(items[i].items);
                    }
                }
            },
            /**
             * Init all items with parameters that are not set
             * @param items
             * @returns {*}
             */
            initItems(items) {
                for (let i in items) {
                    items[i].active = items[i].active || false;
                    items[i].disabled = items[i].disabled || false;

                    if(items[i].id.toString() === this.value) {
                        items[i].active = true;
                    }

                    if (items[i].active) {
                        // set to false because toggle will make it active again
                        items[i].active = false;

                        this.$nextTick(()=>{
                            this.toggleActive(items[i]);
                        })
                    }

                    if (items[i].items && items[i].items.length) {
                        this.initItems(items[i].items);
                        this.noSubcategories = false;
                    }
                }

                return items;
            },

            /**
             * Submit form if set
             * @param item
             */
            submitForm() {
                let $form = null;

                if (this.formSelector !== '') {
                    $form = $(this.formSelector);
                    $form.submit();
                }
            },

            itemClick(item, event) {
                if((!this.disableToggle || this.multipleSelect || (this.disableToggle && !item.active === true))) {
                    this.toggleActive(item, event);
                } else {
                    this.toggleDropdown(false);
                }
            },

            /**
             * Toggle active state
             * @param item
             */
            toggleActive(item, event) {

                if(typeof item === 'undefined' || item.disabled) {
                    return;
                }

                if(this.emptyToggleSelector && !this.multipleSelect && item.id === '') {
                    $(this.emptyToggleSelector).show();
                } else if(this.emptyToggleSelector) {
                    $(this.emptyToggleSelector).hide();
                }

                let state = !item.active;

                if (!this.multipleSelect) {

                    if (this.showSelectedTitle) {

                        if (state) {
                            this.deactivateItems(this.items);
                            this.currentSelection = item.title;
                            item.active = state;
                        } else if (this.placeholder) {
                            this.deactivateItems(this.items);
                            this.currentSelection = this.placeholder;
                            item.active = state;
                        } else {
                            let nullItem = this.items.find(item => item.id === "");
                            if (nullItem) {
                                nullItem.active = true;
                                this.currentSelection = nullItem.title;
                            }
                            item.active = state;
                        }

                        if (typeof event !== 'undefined') {
                            this.$nextTick(this.submitForm);
                        }
                    } else {
                        this.deactivateItems(this.items);
                        item.active = state;
                    }

                    this.isOpen = false;
                } else {
                    item.active = state;
                }

                // Set active items
                if (!this.multipleSelect && item.active) {
                    this.activeItems = [item];
                } else if (!this.multipleSelect && item.active === false) {
                    this.activeItems = [];
                } else if (this.multipleSelect) {

                    if(this.allowOnlyOneGroupSelect === true) {

                        // If we select a group item disable all other groups
                        // Click on first level
                        if(item.items && item.items.length) {
                            this.activeItems = [];
                            this.items.forEach((firstLvlItem)=>{

                                if(firstLvlItem.id !== item.id) {
                                    firstLvlItem.active = false;

                                    if(firstLvlItem.items && firstLvlItem.items.length) {
                                        firstLvlItem.items.forEach((secLvlItem)=>{
                                            secLvlItem.active = false;
                                            secLvlItem.disabled = true;
                                            this.activeItems = this.activeItems.filter((o) => {
                                                return o.id !== secLvlItem.id;
                                            });
                                        });

                                        if(item.active === false) {
                                            firstLvlItem.items.forEach((secLvlItem)=>{
                                                secLvlItem.disabled = false;
                                            });
                                        }
                                    }

                                } else if(firstLvlItem.id === item.id) {
                                    if(firstLvlItem.items && firstLvlItem.items.length) {

                                        firstLvlItem.items.forEach((secLvlItem)=>{
                                            secLvlItem.disabled = false;
                                            secLvlItem.active = false;
                                            this.activeItems = this.activeItems.filter((o) => {
                                                return o.id !== secLvlItem.id;
                                            });
                                        });
                                    }
                                }
                            });
                        } else {

                            let currentFirstLevelItem = null;
                            // Click on second level
                            this.items.forEach((firstLvlItem)=>{
                                // If selected second level item, toggle parent active
                                if(firstLvlItem.items) {
                                    firstLvlItem.items.forEach((secLvlItem)=>{
                                        if(secLvlItem.id === item.id && firstLvlItem.active === false) {
                                            firstLvlItem.active = true;
                                            this.activeItems.push(firstLvlItem);
                                            currentFirstLevelItem = firstLvlItem;
                                        }
                                    });
                                } else if(this.noSubcategories === false && item.id === firstLvlItem.id) {
                                    currentFirstLevelItem = firstLvlItem;
                                    this.activeItems = this.activeItems.filter((o) => {
                                        return o.id === currentFirstLevelItem.id;
                                    });
                                }
                            });

                            if(currentFirstLevelItem) {
                                this.items.forEach((firstLvlItem)=>{

                                    if(currentFirstLevelItem.id !== firstLvlItem.id) {
                                        firstLvlItem.active = false;

                                        if(firstLvlItem.items && firstLvlItem.items.length) {
                                            firstLvlItem.items.forEach((secLvlItem)=>{
                                                secLvlItem.active = false;
                                                secLvlItem.disabled = true;
                                                this.activeItems = this.activeItems.filter((o) => {
                                                    return o.id !== secLvlItem.id;
                                                });
                                            });
                                        }
                                    }
                                });
                            }
                        }
                    } else {
                        // Click on second level
                        this.items.forEach((firstLvlItem)=>{
                            // If selected second level item, toggle parent active
                            if(firstLvlItem.items) {

                                firstLvlItem.items.forEach((secLvlItem)=>{
                                    if(secLvlItem.id === item.id && firstLvlItem.active === false) {
                                        firstLvlItem.active = true;
                                        this.activeItems.push(firstLvlItem);
                                    } else if(firstLvlItem.active === false) {
                                        if(secLvlItem.active) {
                                            secLvlItem.active = false;
                                            this.activeItems = this.activeItems.filter((o) => {
                                                return o.id !== secLvlItem.id;
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    }

                    if (item.active) {
                        this.activeItems.push(item);
                    } else {
                        this.activeItems = this.activeItems.filter((o) => {
                            return o.id !== item.id;
                        });
                    }

                    this.currentSelection = this.activeItems.length ? this.activeItems.map(item => item.title).join(', ') : this.placeholder;
                }

                this.$nextTick(()=>{
                    this.updateSameValueElements();
                });

                if(this.submitOnChange && this.initiated) {
                    this.$nextTick(()=>{
                        $(this.$refs.dropdown).parents('form').submit();
                    });
                }
            },
            updateSameValueElements() {
                this.$nextTick(()=>{
                    if(this.sameValue) {

                        if($(this.sameValue).length > 1) {
                            let val = $(this.sameValue).eq(1).find('[type="hidden"]').val();
                            if(val === '1') {
                                $(this.sameValue).parents('custom-new-line').attr('limit', '0');
                            } else {
                                $(this.sameValue).parents('custom-new-line').attr('limit', '5');
                            }

                            $(this.sameValue).each(function(k) {
                                if(k > 1) {
                                    $(this).attr('is-disabled', 'true');
                                    $(this).attr('value', val);
                                }
                            });
                        }
                    }
                });
            }
        },
        mounted() {
            this.currentSelection = this.placeholder;

            let items = this.options ? JSON.parse(this.options) : [];

            if (items.length) {
                this.items = this.initItems(items);
            }

            const docFunc = (e) => {
                if (this.$refs.dropdown && !this.$refs.dropdown.contains(e.target)) {
                    this.isOpen = false;
                    this.$forceUpdate();
                }
            };

            if (document.body.addEventListener) {
                document.body.addEventListener('click', docFunc, false);
                document.body.addEventListener('touchend', docFunc, false);
            } else if (o.attachEvent) {
                document.body.attachEvent('onclick', docFunc);
                document.body.attachEvent('ontouchend', docFunc);
            }

            this.$nextTick(()=>{

                if (items.length && window.location.hash !== '') {
                    let initVal = this.queryString(this.id + (this.multipleSelect ? '[]' : ''));

                    if(this.multipleSelect && typeof initVal === 'string') {
                        initVal = [initVal];
                    }

                    if (this.multipleSelect && initVal && initVal.length) {
                        initVal.forEach((itemId) => {
                            let itemToActivate = this.items.find((it) => it.id.toString() === itemId);
                            itemToActivate.active = true; //this.toggleActive(itemToActivate);
                        });
                    } else {

                        if (initVal && initVal.toString().trim() !== '') {
                            let itemToActivate = this.items.find((it) => it.id.toString() === initVal);
                            if(!itemToActivate) {
                                this.items.some((item)=>{
                                    if(item.items && item.items.length) {
                                        itemToActivate = item.items.find((it) => it.id.toString() === initVal);
                                        if(itemToActivate) {
                                            return true;
                                        }
                                    }
                                });
                            }
                            itemToActivate.active = true; //this.toggleActive(itemToActivate);
                        }
                    }

                    if(this.showTag) {
                        setTimeout(() => {
                            $('custom-active-filter').trigger('add', [{
                                detail: {
                                    id: this.id,
                                    onClear: this.toggleActive,
                                    items: this.activeItems
                                }
                            }]);
                        }, 500);
                    }
                }
            });

            const toggleFunc = (event) => {

                let updateState = (item) => {
                    this.toggleActive(item);
                    this.$forceUpdate();
                };

                for (let i in this.items) {
                    if (this.items[i].id === event.detail.id) {
                        updateState(this.items[i]);
                    }
                    if (this.items[i].items) {
                        for (let j in this.items[i].items) {
                            if (this.items[i].items[j].id === event.detail.id) {
                                updateState(this.items[i].items[j]);
                            }
                        }
                    }
                }
            };

            // Listen to native js events
            if (this.$root.$el.parentElement.addEventListener) {
                this.$root.$el.parentElement.addEventListener('toggle', toggleFunc, false);
            } else if (this.$root.$el.parentElement.attachEvent) {
                this.$root.$el.parentElement.attachEvent('ontoggle', toggleFunc);
            }

            this.isElmDisabled = this.isDisabled;

            this.$nextTick(()=>{
                this.updateSameValueElements();
                this.initiated = true;
            });

            this.$nextTick(()=>{
                this.loaded = true;
            });

            for(let i in this.$slots) {
                if(i !== 'default') {
                    this.dynamicSlots.push(i);
                }
            }

            const renameTag = function ($obj, new_tag) {
                let obj = $obj.get(0);
                let tag = obj.tagName.toLowerCase();
                let tag_start = new RegExp('^<' + tag);
                let tag_end = new RegExp('<\\/' + tag + '>$');
                let new_html = obj.outerHTML.replace(tag_start, "<" + new_tag).replace(tag_end, '</' + new_tag + '>');
                $obj.replaceWith($(new_html));
            };

            $('.custom-new-line-replace').each(function () {
                $(this).insertAfter($(this));
                renameTag($(this), 'custom-new-line');
            });
        },
        name: 'CustomDropdown'
    }
</script>

<style lang="scss">
    custom-dropdown {
        display: block;
    }

    .custom-dropdown__toggle_content {
        margin-top: 15px;
    }

    .custom-dropdown {

        display: inline-block;
        width: 100%;
        position: relative;
        background-color: $color-yellow;

        @include mq('md', max) {
            max-width: none;
        }

        &.custom-dropdown--disabled {
            .custom-dropdown__placeholder {
                background-color: #f5f5f5 !important;
            }
        }

        .custom-dropdown__placeholder {
            background-color: $color-yellow;
            color: $color-black;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;

            &:after {
                content: " ";
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 8px 7.5px 0 7.5px;
                border-color: $color-black transparent transparent transparent;
                right: 14px;
                top: 21px;
                position: absolute;
            }
        }

        &--filter-active {
            background-color: $color-yellow;

            &.custom-dropdown--normal {
                min-width: 140px;
                background-color: $color-yellow;
                .custom-dropdown__placeholder {
                    background-color: $color-yellow;
                    color: $color-black;
                }
            }

            &.custom-dropdown--light {
                background-color: $color-white;
                .custom-dropdown__placeholder {
                    background-color: $color-white;
                    border: 1px solid $color-input;
                    padding: 14px 40px 14px 20px;
                    font-weight: normal;
                }
            }
        }


        &.custom-dropdown--light {
            background-color: $color-white;
            .custom-dropdown__placeholder {
                background-color: $color-white;
                border: 1px solid $color-input;
                padding: 14px 40px 14px 20px;
                font-weight: normal;
            }

            &.custom-dropdown--open {
                .custom-dropdown__placeholder {
                    border: 1px solid $color-yellow-active;
                }
            }
        }

        &--normal {
            background-color: $color-yellow;

            &.custom-dropdown--light {
                background-color: $color-white;
                .custom-dropdown__placeholder {
                    background-color: $color-white;
                    border: 1px solid $color-input;
                    padding: 14px 40px 14px 20px;
                    font-weight: normal;
                }
            }

            .custom-dropdown__link {
                padding: 7px 20px 6px 20px;
            }

        }

        &__placeholder {
            width: 100%;
            text-align: left;
            padding: 15px 40px 15px 20px;
            cursor: pointer;
            position: relative;
            display: block;
            appearance: none;
            background-color: $color-yellow;
            border: 0;

            &:focus {
                outline: none;
            }
        }
        &.custom-dropdown--open {
            background-color: #fff;
            border-bottom-color: transparent;
            z-index: 999;

            .custom-dropdown__placeholder {
                background-color: $color-yellow-active;
                color: $color-black;
            }
        }

        &__layer {
            padding-bottom: 5px;
            position: absolute;
            width: auto;
            top: 100%;
            background-color: #fff;
            border-top: 0;
            min-width: 100%;
            z-index: 10;
            box-shadow: 0px 4px 40px #a9a9a9;
        }

        &__items {
            padding: 0;
            list-style: none;
            max-height: 300px;
            overflow: auto;
            margin: 0;

            &::-webkit-scrollbar {
                width: 5px;
            }

            &::-webkit-scrollbar-track {
                background: #ddd;
            }

            &::-webkit-scrollbar-thumb {
                background: #666;
            }

            .custom-dropdown__item {
                &:last-child {
                    > a {
                        border-bottom: 0;
                    }
                }
            }
        }
        &__link {
            cursor: pointer;
            padding: 15px 20px 10px 20px;
            display: block;
            text-decoration: none;
            color: $color-black;
            position: relative;
            word-break: break-word;

            &:focus {
                outline: none;
                text-decoration: underline;
            }
            &:active,
            &:visited,
            &:hover {
                text-decoration: none;
                color: $color-black;
            }
        }

        &__item {
            position: relative;
            list-style: none;
            margin: 0;

            &:before {
                content: "";
            }

            > a {
                &:hover {
                    background-color: $color-yellow-active;
                }
            }
        }

        &__group {
            padding: 7px 20px 6px 20px;
            font-weight: bold;
        }

        &__btn-save {
            width: calc(100% - 30px);
            padding: 8px 15px;
            margin: 15px 15px 10px;
            -webkit-appearance: none;
            background-color: $color-yellow;
            border: 0;
        }

        .custom-dropdown__link {
            white-space: nowrap;
            @include mq('sm') {
                white-space: normal;
            }
            &.custom-dropdown__link--disabled {
                opacity: 0.4;
            }
        }

        &--multiple {


            .custom-dropdown__group,
            .custom-dropdown__link {
                text-decoration: none;
                padding: 13px 20px 10px 20px;
                span {
                    position: relative;
                    display: block;
                    padding-left: 35px;
                    white-space: nowrap;
                    text-decoration: none;

                    &:hover,
                    &:focus,
                    &:active {
                        text-decoration: none;
                    }
                    &:after {
                        display: none;
                    }
                    &:before {
                        content: " ";
                        display: block;
                        box-sizing: border-box;
                        width: 22px;
                        height: 22px;
                        background-color: #fff;
                        border: 1px solid #F9B000;
                        padding: 2px 0 0 4px;
                        line-height: 1;
                        top: 0px;
                        position: absolute;
                        left: 0;
                        @include mq('sm', max) {
                            top: 12px;
                        }
                    }
                }
            }
            .custom-dropdown__item--active {
                text-decoration: none;
                > .custom-dropdown__link {
                    span {
                        text-decoration: none;
                        &:hover {
                            text-decoration: none;
                        }
                        &:before {
                            &:hover {
                                text-decoration: none;
                            }
                        }
                        @include icon($icon-check, 'before') {
                            line-height: 1;
                            color: $color-yellow-active;
                            padding: 2px;
                            font-size: 0.9rem;
                            display: block;
                        }
                    }
                }
            }
        }
        .custom-dropdown__layer {
            > div {
                padding: 30px 30px 10px;
            }
        }
        .custom-dropdown__groupitems {
            .custom-dropdown__link {
                padding-left: 35px;
            }
        }
        .custom-dropdown__hidden {
            height: 0;
            width: 0;
            opacity: 0;
            position: absolute;
            bottom: 0;
            left: 50%;
        }

        .custom-dropdown__item-link--active {
            background-color: #e8e8e8;
        }

        &.input--error {
            .custom-dropdown__placeholder {
                border: 1px solid #d81018;
            }
        }

    }
</style>
