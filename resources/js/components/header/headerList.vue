<template>
    <div>
        <ul class="nav nav-pills">
            <headerItem v-for="link in links" :key="link" :link="link.link" :active="link.selected">{{link.title}}</headerItem>
        </ul>
    </div>
</template>

<script>
import headerItem from './headerItem.vue';


    export default {
        props: ['links'],
        components: { headerItem }
    }
</script>

<style>

</style>