<template>
    <div>
        <summaryDropdown v-for="summary in data" :key="summary.id" 
        :d="summary" :masterData="data">
        </summaryDropdown>
    </div>
</template>

<script>
import summaryView from "./summary-view.vue";
import summaryDropdown from "./summary-dropdown.vue";
export default {
    props: ['d'],
    data: function() {
        return {
            data: this.d.reverse(),
        }
    },
    methods: {
    
    },
    components: {summaryDropdown}
}
</script>

<style>

</style>