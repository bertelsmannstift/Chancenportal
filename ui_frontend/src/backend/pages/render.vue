<template>
    <div v-if="component">
        <component :is="component"></component>
    </div>
</template>
