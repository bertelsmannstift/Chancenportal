<template>
    <div class="custom-chart">
        <div class="custom-chart__item custom-chart__item--header">
            <div class="custom-chart__count">
                Anzahl
            </div>
            <div class="custom-chart__name">
                Kategorie
            </div>
        </div>
        <div v-for="item in currentItems" class="custom-chart__item">
            <div class="custom-chart__count">
                {{item.count}}
            </div>
            <div class="custom-chart__name">
                <div class="custom-chart__counter">
                    <div class="custom-chart__counter-bar" :style="{width: item.width + '%'}"></div>
                    <div class="custom-chart__counter-text">{{item.name}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'custom-chartComponent',
        props: {
            items: '',
            limit: {
                default: true,
                type: Boolean
            },
        },
        data() {
            return {
                currentItems: [],
                initItems: [],
                limitCount: 2,
            }
        },
        watch: {
            limit(val) {
                if(val) {
                    this.currentItems = this.initItems.slice(0, this.limitCount);
                } else {
                    this.currentItems = this.initItems;
                }
            }
        },
        mounted() {
            let items = JSON.parse(this.items);
            let sum = 0;
            items.forEach((item)=>{
                sum += item.count;
            });
            items.forEach((item)=>{
                item.width = (item.count * 100) / sum;
            });
            this.initItems = items;
            this.currentItems = this.initItems.slice(0, this.limitCount);
        }
    }
</script>

<style lang="scss">
    custom-chart {
        display: block;
    }
    .custom-chart {
        width: 100%;
        .custom-chart__item {
            width: 100%;
            margin-bottom: 5px;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            @include font-size(14);
            @include mq('sm') {
                display: block;
            }
        }
        .custom-chart__count {
            width: 15%;
            display: flex;
            align-items: center;
            @include font-size(14);
        }
        .custom-chart__item--header {
            > div {
                font-weight: bold;
                display: block;
                padding-bottom: 10px;
                @include font-size(14);
            }
        }
        .custom-chart__counter {
            position: relative;
            padding: 10px 20px;
            .custom-chart__counter-bar {
                position: absolute;
                z-index: 0;
                height: 100%;
                left:0;
                top:0;
                width: auto;
                background-color: $color-gray-light;
            }
        }
        .custom-chart__counter-text {
            position: relative;
            z-index: 2;
        }
        .custom-chart__name {
            flex: 1;
        }
    }

</style>
