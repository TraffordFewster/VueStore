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
                                {{getProduct(product.product_id).name}}    
                            </td>
                            <td class="align-middle">
                                <input class="form-control" :class="{'border border-danger':errors[product.id + 'amount']}" @keydown="errors[product.id + 'amount'] = false" type="number" name="amount" v-model="product.amount">
                            </td>
                            <td class="align-middle">
                                <button @click="editProduct(product)" class="btn btn-success" :disabled="updateLocked"><i class="fas fa-save"></i></button>
                                <button @click="removeProduct(product)" class="btn btn-danger" :disabled="updateLocked"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <Multiselect @selected='productCreateSelect' class="w-100" :options="allproducts"></Multiselect>
                            </td>
                            <td>
                                <input class="form-control" type="number" name="amount" v-model="newproduct.amount">
                            </td>
                            <td>
                                <button @click="createProduct" class="btn btn-success" :disabled="updateLocked"><i class="fas fa-plus"></i></button>
                                <button class="btn btn-danger" :disabled="updateLocked"><i class="fas fa-trash"></i></button>
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
        getProduct: function(id){
            for (let p in this.allproducts){
                if (this.allproducts[p].id == id)
                {
                    return this.allproducts[p];
                }
            }
        },
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
        
        },
        editProduct: function(invoiceProduct) {
            this.updateLocked = true;
            let ogThis = this;
            axios.put(`/invoice/${this.data.id}/products/${invoiceProduct.id}`,{amount: invoiceProduct.amount})
            .then(function() {
                ogThis.$emit('editted', ogThis.data)
                ogThis.$toast.success(`${getProduct(invoiceProduct.product_id).name} amount has been updated!`)
            })
            .catch(function (err) {
                console.log(err);
                ogThis.errors[invoiceProduct.id+'amount'] = true;
                for (const property in err.response.data.errors)
                {
                    let msg = err.response.data.errors[property][0]
                    ogThis.$toast.error(msg)
                }
            })
            .finally(function() {
                ogThis.updateLocked = false;
            })
        },
        removeProduct: function(invoiceProduct) {
            this.updateLocked = true;
            let ogThis = this;
            axios.delete(`/invoice/${this.data.id}/products/${invoiceProduct.id}`)
            .then(function() {
                for (let product in ogThis.data.products)
                {
                    let p = ogThis.data.products[product].id
                    if (p == invoiceProduct.id)
                    {
                        ogThis.data.products.splice(product,1)
                        break
                    }
                }
                ogThis.$emit('editted', ogThis.data)
                ogThis.$toast.success(`${ogThis.getProduct(invoiceProduct.product_id).name} has been removed from the invoice!`);           
            }).catch(function(err) {
                console.log(err)
                ogThis.$toast.error('Oops! Something went wrong, please check console!')
            }).finally(function() {
                ogThis.updateLocked = false;
            })
        },
        productCreateSelect: function(selected) 
        {
            this.newproduct.productid = selected.id;
        },
        createProduct: function() 
        {
            let ogThis = this
            if (!this.newproduct.productid){
                ogThis.$toast.error('Select a product!')
                return;
            }
            if (!this.newproduct.amount){
                ogThis.$toast.error('Please enter an amount!')
                return;
            }
            ogThis.updateLocked = false;
            axios.post(`/invoice/${this.data.id}/products`, {product_id: this.newproduct.productid, amount: this.newproduct.amount})
            .then(function(response){
                console.log(response.data)
                ogThis.data.products.push(response.data)
                ogThis.$emit('editted', ogThis.data)
                ogThis.$toast.success("Success")
            })
            .catch(function(err){
                console.log(err)
                ogThis.$toast.error("Oops something went wrong! please check the console.")
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