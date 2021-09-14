<template>
  <span>
      <button type="button" class="btn btn-warning" v-on:click="showModal = true">Edit</button>
      <tmodal :show="showModal" :title="'Edit Invoice #'+invoice.id" @close="close" :large="true">
            <form v-on:submit.prevent="">
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label :for="data.id + 'name'" class="form-label">Bill To</label>
                        <input :id="data.id + 'name'" type="text" class="form-control" :class="{'border border-danger':errors['billToName']}" @keydown="errors['billToName'] = false" v-model="data.billToName">
                    </div>
                    <div class="mb-3">
                        <label :for="data.id + 'addr'" class="form-label">Address</label>
                        <input :id="data.id + 'addr'" type="text" class="form-control mb-1" :class="{'border border-danger':errors['billToAddr1']}" @keydown="errors['billToAddr1'] = false" v-model="data.billToAddr1">
                        <input :id="data.id + 'addr2'" type="text" class="form-control" :class="{'border border-danger':errors['billToAddr2']}" @keydown="errors['billToAddr2'] = false" v-model="data.billToAddr2">
                    </div>
                    <div class="mb-3">
                        <label :for="data.id + 'addr'" class="form-label">Due Date</label>
                        <datepicker :input-class="{'form-control':true, 'border border-danger':errors['dueDate']}" :disabled-dates="{days:[0,6]}" v-model="data.dueDate" @selected="errors['dueDate'] = false" style="color:black"></datepicker>
                    </div>
                    <button v-on:click="edit" :disabled="updateLocked" class="btn btn-success w-100">Update</button>
                </div>
            </form>
            <div class="modal-footer">
                <table class="table" style="max-width: 100%;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in data.products" :key="product.id">
                            <td class="align-middle">
                                {{product.product.name}}    
                            </td>
                            <td class="align-middle">
                                <input class="form-control" type="number" name="amount" v-model="product.amount">
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-success"><i class="fas fa-save"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <Multiselect class="w-100" :options="allproducts"></Multiselect>
                            </td>
                            <td>
                                <input class="form-control" type="number" name="amount" v-model="newproduct.amount">
                            </td>
                            <td>
                                <button class="btn btn-success"><i class="fas fa-plus"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
      </tmodal>
  </span>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import Multiselect from 'vue-simple-search-dropdown';
export default {
    props: ['invoice','allproducts'],
    data: function () {
        return {
            data: {...this.invoice},
            showModal: false,
            newproduct: {},
            errors: {},
            updateLocked: false
        }
    },
    computed: {
        dueDate : function () {
            if (typeof this.data.dueDate === 'string')
            {
                return this.data.dueDate;
            } else {
                return this.data.dueDate.toISOString().split('T')[0]
            }
        }
    },
    methods: {
        close: function() {
            this.data = {...this.invoice}
            this.showModal = false;
            this.errors = {}
        },
        edit: function() {
            let ogThis = this;
            this.updateLocked = true;
            axios.put('/invoice/' + this.invoice.id, {
                billToName: this.data.billToName,
                billToAddr1: this.data.billToAddr1,
                billToAddr2: this.data.billToAddr2,
                dueDate: this.dueDate})
            .then(function() {
                ogThis.$emit('editted', ogThis.data)
                ogThis.$toast.success(`Invoice #${ogThis.invoice.id} successfully updated!`)
            })
            .catch(function (err) {
                console.log(err);
                ogThis.errors = err.response.data.errors;
                for (const property in ogThis.errors)
                {
                    let msg = ogThis.errors[property][0]
                    ogThis.$toast.error(msg)
                }

            })
            .finally(function(){
                ogThis.updateLocked = false;
            })
        
        }
    },
    components: {
        Datepicker,
        Multiselect
    }
}
</script>

<style>

</style>