<template>
  <span>
      <button type="button" class="btn btn-warning" v-on:click="showModal = true">Edit</button>
      <tmodal :show="showModal" :title="'Edit Invoice #'+invoice.id" @close="close" :large="true">
            <form v-on:submit.prevent="" autocomplete="off">
                <div class="modal-body text-start">
                    <invoiceBasicsForm :updateLocked="updateLocked" :errors="errors" :model="data"></invoiceBasicsForm>
                    <button v-on:click="edit" :disabled="updateLocked" class="btn btn-success w-100">Update</button>
                </div>
            </form>
            <form v-on:submit.prevent="" class="modal-footer" autocomplete="off">
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
                        <invoiceNewProduct @Create="createProduct" :v-model="newproduct" :updateLocked="updateLocked" :allproducts="allproducts">
                        </invoiceNewProduct>
                    </tfoot>
                </table>
            </form>
      </tmodal>
  </span>
</template>

<script>
import invoiceNewProduct from './invoice-product-new.vue';
import invoiceBasicsForm from './invoice-basics-form.vue';
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
                ogThis.$toast.success(`${ogThis.getProduct(invoiceProduct.product_id).name} amount has been updated!`)
            })
            .catch(function (err) {
                console.log(err);
                ogThis.errors[invoiceProduct.id+'amount'] = true;
                for (const property in err.response.data.errors)
                {
                    let msg = err.response.data.errors[property][0]
                    ogThis.$toast.error(msg)
                }
            }).catch(function(err) {
                console.log(err)
                ogThis.$toast.error('Oops! Something went wrong, please check console!')
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
        createProduct: function() 
        {
            let ogThis = this
            if (!this.newproduct.productid){
                ogThis.$toast.error('Select a product!')
                return;
            }
            if (!this.newproduct.amount || this.newproduct.amount <= 0){
                ogThis.$toast.error('Please enter an amount above 0!')
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
        invoiceBasicsForm,
        invoiceNewProduct
    }
}
</script>

<style>

</style>