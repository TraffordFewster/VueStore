<template>
    <div>
        <button type="button" class="btn btn-success btn-sm mt-2 w-100" v-on:click="showModal = true">Create</button>
        <tmodal :show="showModal" title="Create Product" @close="close">
            <form>
                <div class="modal-body">
                    <errordisplay :errors="errors"></errordisplay>

                    <div class="mb-3">
                        <label for="Title" class="form-label">Item Name</label>
                        <input v-on:keydown="clearError('name')" :class="{'border border-danger':nameError}" v-model="newItem.title" type="text" class="form-control" id="Title">
                    </div>

                    <div class="mb-3">
                        <label for="Price" class="form-label">Item Price</label>
                        <input v-on:keydown="clearError('price')" :class="{'border border-danger':priceError}" v-model="newItem.price" type="number" class="form-control" id="Price">
                    </div>


                </div>
                <div class="modal-footer">
                    <button v-on:click="close" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input :disabled="submitDisabled" type="submit" class="btn btn-primary" v-on:click="submit">
                </div>
            </form>
        </tmodal>
    </div>
    
</template>

<script>
import errordisplay from '../error-display.vue';
export default {
    data : function () {
        return {
            showModal:false,
            checking:false,
            newItem: {name:"",price:"0.00"},
            errors: {},
        }
    },
    computed: {
        submitDisabled: function() {
            return this.checking || this.errors[0]
        },
        nameError: function() {
            return this.errors['name'] != undefined && this.errors['name'][0] != undefined
        },
        priceError: function() {
            return this.errors['price'] != undefined && this.errors['price'][0] != undefined
        },
    },
    methods: {
        close : function () {
            this.showModal = false
        },
        submit : function () {
            let submitThis = this;
            submitThis.checking = true;
            axios.post("/product", {name: submitThis.newItem.title, price: submitThis.newItem.price})
            .then(data => {
                setTimeout( ()=> submitThis.close(), 0)
                submitThis.$emit("new",data.data)
                submitThis.$toast.success("New product created!")
            })
            .catch(function (err) {
                console.log(err);
                submitThis.errors = err.response.data.errors;
                for (const property in submitThis.errors)
                {
                    let msg = submitThis.errors[property][0]
                    submitThis.$toast.error(msg)
                }

            })
            .finally(() => {
                submitThis.checking = false;
            })
        },
        clearError: function(key) {
            this.errors[key] = [];
        }
    },
    components: {errordisplay},
}
</script>

<style>

</style>