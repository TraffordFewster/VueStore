<template>
  <span>
      <button type="button" class="btn btn-dark" v-on:click="showModal = true">Archive</button>
      <confirmBox :show="showModal" @accept="remove" @deny="showModal = false">
          Archive invoice #{{invoice.id}} addressed to {{invoice.billToName}}?
      </confirmBox>
  </span>
</template>

<script>
import confirmBox from '../confirmBox.vue'
export default {
    props: ['invoice'],
    components: {confirmBox},
    data: function() {
        return {
            showModal: false,
        }
    },
    methods: {
        remove: function() {
            let ogThis = this;
            axios.post(`/invoice/${ogThis.invoice.id}/archive`)
            .then(function(){
                ogThis.$toast.success("Invoice Archived!")
                ogThis.$emit('archive')
            })
            .catch(function(){
                ogThis.$toast.error("Oops! Something went wrong, please check the console.")
            })
            .finally(function(){
                ogThis.showModal = false;
            })
        }
    },
}
</script>

<style>

</style>