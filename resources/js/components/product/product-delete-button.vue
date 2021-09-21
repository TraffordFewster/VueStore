<template>
    <span>
        <button title="Delete" type="button" class="btn btn-danger py-2" v-on:click="show = true"><i class="fas fa-trash-alt"></i></button>
        <tmodal :show="show" @close="close" :title="'Delete ' + item.title +'?'">
            <div class="modal-body">

                <p>Are you sure you want to delete "{{this.item.title}}"?</p>
                
                <button type="button" class="btn btn-secondary btn-lg btn-block" v-on:click="close" >Cancel</button>
                <button type="button" :disabled="sending" class="btn btn-danger btn-lg btn-block" v-on:click="del">Delete</button>

            </div>
        </tmodal>
    </span>
</template>

<script>
export default {
    props: ['item'],
    data: function () {
        return {
            show : false,
            sending: false,
            errors: {}
        }
    },
    methods: {
        close: function () {this.show = false},
        del: function () {
            this.sending = true;
            let thisthis = this;
            axios.delete('/product/' + this.item.id)
            .then(function(){
                thisthis.$emit('deleted');
                setTimeout(()=>thisthis.close(),0);
            })
            .catch(function(){
                // Just catching error so its not super big in console, should never happen but just incase.
            })
            .finally(function(){
                thisthis.sending = false;
            })
        }
    }
}
</script>

<style>

</style>