<template>
    <nav class="navbar navbar-light bg-dark">
        <div class="container">
            <headerBrand></headerBrand>
            <headerList :links="links"></headerList>
        </div>
    </nav>
</template>

<script>
    // Vue.component('headerBrand',require('./header/headerBrand.vue').default)
    import headerBrand from "./header/headerBrand.vue";
    import headerList from "./header/headerList.vue";

    export default {
        data () {
            return {}
        },
        components: {
            headerBrand,
            headerList
        },
        props : ["links"]
    }
</script>

<style>

</style>