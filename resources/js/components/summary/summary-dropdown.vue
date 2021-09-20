<template>
    <tcollapse v-slot="{summary}" 
    :title="summary.id + ' | ' + summary.created_at.split('T')[0]" 
    @mouseover="getData(summary)" @blockToggle="shouldBlockToggle">
        <summaryView :data="d.data || {}"></summaryView>
    </tcollapse>
</template>
// I don't understant why I have to slot in summary when I use d.data on the summary view, 
// but if I use summary.data in the summary view I have to provide slot data of d?
<script>
import summaryView from "./summary-view.vue";
export default {
    props: ["d","masterData"],
    data: function() {
        return {summary: this.d}
    },
    methods: {
        getData: function(summary) // Should have done this in other places aswell.
        {
            if (!summary.data)
            {
                let _this = this;
                axios.get(`/summary/${summary.id}`)
                .then(function(response){
                    summary.data = response.data;
                })
                .catch(function(){
                    _this.$toast.error("Oops! An error has occured!")
                })
            }
        },
        shouldBlockToggle: function(callback) {
            if (this.summary.data)
            {
                callback(false)
            } else {
                this.$toast.warning("The summary is still loading!")
                callback(true)
            }
        }
    },
    components: {summaryView},
}
</script>

<style>

</style>