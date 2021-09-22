<template>
    <span>
        <button title="Delete" type="button" class="btn btn-danger py-2" v-on:click="show = true"><i class="fas fa-trash-alt"></i></button>
        <confirmBox :show="show" @deny="close" @accept="del">
            Are you sure you want to delete "{{this.item.title}}"?
        </confirmBox>
    </span>
</template>

<script>
import confirmBox from '../confirmBox.vue';
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
    },
    components: {confirmBox},
}
</script>

<style>

</style>