<template>
    <div>
        <tcollapse v-slot="{data}" v-for="summary in data" :key="summary.id" 
        :title="summary.id + ' | ' + summary.created_at.split('T')[0]" 
        @mouseover="getData(summary)">
            <summaryView :data="summary.data"></summaryView>
        </tcollapse>
    </div>
</template>

<script>
import summaryView from "./summary-view.vue";
export default {
    props: ['d'],
    data: function() {
        return {
            data: this.d.reverse(),
        }
    },
    methods: {
        getData: function(summary) // Should have done this in other places aswell.
        {
            if (!summary.data)
            {
                let _this = this;
                summary.data = {};
                axios.get(`/summary/${summary.id}`)
                .then(function(response){
                    summary.data = response.data;
                })
                .catch(function(){
                    _this.$toast.error("Oops! An error has occured!")
                })
            }
        }
    },
    components: {summaryView}
}
</script>

<style>

</style>