<template>
    <span class="mr-2">
        <input @change="$emit('change')" v-model="m" type="checkbox" class="btn-check" :id="filterName" autocomplete="off">
        <label class="btn" :class="'btn-outline-' + type" :for="filterName">{{filterName}}</label><br>
    </span>
</template>

<script>
export default {
    props:['filterName','type','model'],
    data: function () {
        return {
            m: this.model,
        }
    }
}
</script>

<style scoped>
    input{
        display: none;
    }
</style>