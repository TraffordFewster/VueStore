<template>
  <span>
        <button type="button" class="btn btn-success btn-sm mt-2 w-100" v-on:click="showModal = true">Create</button>
        <tmodal :show="showModal" title="Create Invoice" @close="showModal = false">
            <form  v-on:submit.prevent="">
                <div class="modal-body">
                    <invoiceBasicsForm :errors="errors" :model="data"></invoiceBasicsForm>
            
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
                                    {{getProduct(product.productid).name}}    
                                </td>
                                <td class="align-middle">
                                    <input class="form-control" :class="{'border border-danger':errors[product.id + 'amount']}" @keydown="errors[product.id + 'amount'] = false" type="number" name="amount" v-model="product.amount">
                                </td>
                                <td class="align-middle">
                                    <button @click="removeProduct(product)" class="btn btn-danger" :disabled="updateLocked"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <invoiceNewProduct @Create="createProduct" :v-model="newproduct" :updateLocked="updateLocked" :allproducts="allproducts">
                            </invoiceNewProduct>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button :disabled='updateLocked' @click="create" type="submit" class="w-100 btn btn-success">Submit</button>
                </div>
            </form>
        </tmodal>
  </span>
</template>

<script>
import invoiceNewProduct from './invoice-product-new.vue';
import invoiceBasicsForm from './invoice-basics-form.vue';
export default {
    props: ['allproducts'],
    data: function() {
        return {
            showModal: false,
            updateLocked:false,
            errors: {},
            data: {products: []},
            newproduct: {},
            newproductID: 0,
        }
    },
    components: {invoiceNewProduct,invoiceBasicsForm},
    computed: {
        dueDate: function() {
            if (!this.data.dueDate) {
                return ""
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
        create: function() {
            let data = this.data;
            let ogThis = this;
            let productsErrors = 0;
            data.products.forEach(product => {
                if (product.amount <= 0){
                    productsErrors++
                }
            });
            if (productsErrors > 0) {
                this.$toast.error(`${productsErrors} product(s) have an invalid amount!`)
                return
            }
            ogThis.updateLocked= true;
            axios.post('/invoice',{
                'billToName' : data.billToName,
                'billToAddr1' : data.billToAddr1,
                'billToAddr2' : data.billToAddr2,
                'dueDate' : this.dueDate,
                'products' : JSON.stringify( data.products ),
                })
                .then((response) => {
                    ogThis.showModal = false;
                    ogThis.$toast.success('Invoice added!')
                })
                .catch((err) => {
                    console.log(err);
                    if (!err.response.data.errors){
                        ogThis.$toast.error('Oops! An unknown error has occured!')
                    }
                    ogThis.errors = err.response.data.errors || {};
                    for (const property in ogThis.errors)
                    {
                        let msg = ogThis.errors[property][0]
                        ogThis.$toast.error(msg)
                    }
                })
                .finally(() => {
                    ogThis.updateLocked= false;
                })
        },
        createProduct: function() {
            if (!this.newproduct.productid){
                this.$toast.error('Select a product!')
                return;
            }
            if (!this.newproduct.amount || this.newproduct.amount <= 0){
                this.$toast.error('Please enter an amount above 0!')
                return;
            }
            this.newproduct.id = this.newproductID++
            this.data.products.push({...this.newproduct})
        },
        removeProduct: function(product)
        {
            for (let p in this.data.products)
            {
                if (this.data.products[p].id == product.id)
                {
                    this.data.products.splice(p,1)
                    break
                }
            }
        }
    }
}
</script>

<style>

</style>