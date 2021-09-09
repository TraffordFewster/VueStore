<template>
  <div class="modal fade" :class="{show : show, 'd-block' : show}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" v-on:click.self="close">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{this.title}}</h5>
                    <button v-on:click="close" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <slot>
                </slot>
            </div>
        </div>
  </div>
</template>

<script>
export default {
    props: ['show','title'],
    methods: {
        close: function () {
            this.$emit("close")
        }
    }
}
</script>

<style scoped>
    .modal{
        background-color: #000000ad;
    }
</style>