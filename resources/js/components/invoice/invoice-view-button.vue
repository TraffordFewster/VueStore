<template>
    <span>
        <button title="View" type="button" class="btn btn-primary py-2" v-on:click="showModal = true"><i class="fas fa-eye"></i></button>
        <tmodal :show="showModal" title="View Invoice" @close="close">
            <div class="modal-body">
                <h4>Invoice #{{data.id}}</h4>
                <hr>
                <h5 class="text-start">{{data.billToName}}</h5>
                <h6 class="text-start">{{data.billToAddr1}}</h6>
                <h6 class="text-start">{{data.billToAddr2}}</h6>
                <br>
                <table class="w-100 table-primary">
                    <tr>
                        <th class="col">Name</th>
                        <th class="col">Price Per</th>
                        <th class="col">Amount</th>
                        <th class="col">Total Due</th>
                    </tr>
                    <tr v-for="product in data.products" :key="product.id">
                        <td>{{getProduct(product.product_id).name}}</td>
                        <td>£{{getProduct(product.product_id).price}}</td>
                        <td>{{product.amount}}</td>
                        <td>{{(Math.round((getProduct(product.product_id).price * product.amount) * 100) * 0.01).toLocaleString('en-US', { style: 'currency', currency: 'GBP', })}}</td>
                    </tr>
                    <br>
                    <h6>Total: {{totalValue}}</h6>
                    <h6 class="text-start">Due: {{data.dueDate}}</h6>
                </table>
            </div>
            <div class="modal-footer">
                <form class="w-100">
                    <div class="mb-3">
                        <label :for="data.id + 'emailSendInput'" class="form-label">Email address</label>
                        <input v-model="sendToEmail" type="email" class="form-control" :id="data.id + 'emailSendInput'" name="email">
                        <div class="form-text">Who to send the invoice to.</div>
                    </div>
                    <button :disabled="lockEmail" @click.prevent="sendEmail" class="btn btn-success w-100">Send</button>
                </form>
            </div>
        </tmodal>
    </span>
</template>

<script>
export default {
    props: ['invoice','allproducts'],
    data: function () {
        return {
            data: this.invoice,
            showModal: false,
            sendToEmail: "",
            lockEmail: false,
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
            this.showModal = false;
            this.sendToEmail = "";
        },
        sendEmail: function() 
        {
            this.lockEmail = true;
            let _this = this;
            _this.$toast.warning(`Generating the invoice!`)
            axios.post(`/invoice/${this.invoice.id}/email`, {'email' : this.sendToEmail})
            .then(function(response){
                _this.$toast.success("Invoice sent!")
            })
            .catch(function(err){
                console.log(err);
                if (!err.response.data.errors){
                    _this.$toast.error('Oops! An unknown error has occured!')
                }
                _this.errors = err.response.data.errors || {};
                for (const property in _this.errors)
                {
                    let msg = _this.errors[property][0]
                    _this.$toast.error(msg)
                }
            })
            .finally(function(){
                _this.lockEmail = false;
            })

        }
    },
    computed: {
        totalValue : function() {
            let total = 0 
            for (let i = 0; i < this.data.products.length; i++)
            {
                let p = this.data.products[i];
                total += p.amount * this.getProduct(p.product_id).price;
            }
            return (Math.round(total * 100) * 0.01).toLocaleString('en-US', {
                style: 'currency',
                currency: 'GBP',
            });
        },
    },
}
</script>

<style>

</style>