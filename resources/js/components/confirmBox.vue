<template>
  <tmodal :show="show" title="Confirmation" @close="deny">
      <div class="modal-body">
          <slot></slot>
      </div>
      <div class="modal-footer">
          <button @click="accept" type="button" class="btn btn-success">Yes</button>
          <button @click="deny" type="button" class="btn btn-secondary">No</button>
      </div>
  </tmodal>
</template>

<script>
export default {
    props : ['show'],
    methods : {
        deny: function() {
            this.$emit('deny')
        },
        accept: function() {
            this.$emit('accept')
        }
    }
}
</script>

<style scoped>
    button {
        width: 40%;
        margin: auto;
    }
</style>