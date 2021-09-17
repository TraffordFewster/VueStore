<template>
  <div>
      <button @mouseover="$emit('mouseover')" @click="toggle" class="btn btn-secondary w-100 mt-2" type="button">{{title}}</button>
      <div v-show="show">
          <slot></slot>
      </div>
  </div>
</template>

<script>
export default {
    props: ['title','expanded'],
    data: function() {
        return {
            show: this.expanded || false,
        }
    },
    methods: {
        toggle: function() {
            this.show = !this.show;
        }
    }
}
</script>

<style>

</style>