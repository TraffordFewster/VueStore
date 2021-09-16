<template>
  <span>
      <button type="button" class="btn btn-danger" v-on:click="showModal = true">Delete</button>
      <confirmBox :show="showModal" @accept="remove" @deny="showModal = false">
          Remove invoice #{{invoice.id}} addressed to {{invoice.billToName}}?
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
            axios.delete(`/invoice/${ogThis.invoice.id}`)
            .then(function(){
                ogThis.$toast.success("Invoice deleted!")
                ogThis.$emit('remove')
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