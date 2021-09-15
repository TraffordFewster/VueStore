<template>
    <form v-on:submit.prevent="">
        <div class="modal-body text-start">
            <div class="mb-3">
                <label :for="model.id + 'name'" class="form-label">Bill To Name</label>
                <input :id="model.id + 'name'" type="text" class="form-control" :class="{'border border-danger':errors['billToName']}" @keydown="errors['billToName'] = false" v-model="model.billToName">
            </div>
            <div class="mb-3">
                <label :for="model.id + 'addr'" class="form-label">Bill To Address</label>
                <input :id="model.id + 'addr'" type="text" class="form-control mb-1" :class="{'border border-danger':errors['billToAddr1']}" @keydown="errors['billToAddr1'] = false" v-model="model.billToAddr1">
                <input :id="model.id + 'addr2'" type="text" class="form-control" :class="{'border border-danger':errors['billToAddr2']}" @keydown="errors['billToAddr2'] = false" v-model="model.billToAddr2">
            </div>
            <div class="mb-3">
                <label :for="model.id + 'addr'" class="form-label">Due Date</label>
                <datepicker :input-class="{'form-control':true, 'border border-danger':errors['dueDate']}" :disabled-dates="{days:[0,6]}" v-model="model.dueDate" @selected="errors['dueDate'] = false" style="color:black"></datepicker>
            </div>
            <button v-on:click="submit" :disabled="updateLocked" class="btn btn-success w-100">Update</button>
        </div>
    </form>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    props: ['model','errors','updateLocked'],
    methods: {
        submit: function() {
            this.$emit('submit')
        },
    },
    components: {Datepicker},
}
</script>

<style>

</style>