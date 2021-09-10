<template>
    <span>
        <button type="button" class="btn btn-primary" v-on:click="buttonPressed">Edit</button>
        <editModal :item="this.item" :show="showModal" @closeModal="closeModal" @update="update"></editModal>
    </span>
</template>

<script>
import editModal from './product-edit-modal.vue';
export default {

    props: ['item'],
    components: {
        editModal,
    },
    data: function () {
        return {
            showModal : false,
        }
    },
    methods: {
        buttonPressed: function (event) {
            // this.item.title = this.item.price;
            // this.$emit('updated',this.item)
            this.showModal = true
        },

        update: function(data){
            this.$emit('updated',data)
        },

        closeModal: function () {
            this.showModal = false
        }
    },
}
</script>

<style>

</style>