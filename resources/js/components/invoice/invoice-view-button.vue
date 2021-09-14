<template>
    <span>
        <button type="button" class="btn btn-primary" v-on:click="showModal = true">View</button>
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
                        <td>{{product.product.name}}</td>
                        <td>£{{product.product.price}}</td>
                        <td>{{product.amount}}</td>
                        <td>{{(Math.round((product.product.price * product.amount) * 100) * 0.01).toLocaleString('en-US', { style: 'currency', currency: 'GBP', })}}</td>
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
                        <input type="email" class="form-control" :id="data.id + 'emailSendInput'" name="email">
                        <div class="form-text">Who to send the invoice to.</div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Send</button>
                </form>
            </div>
        </tmodal>
    </span>
</template>

<script>
export default {
    props: ['invoice'],
    data: function () {
        return {
            data: this.invoice,
            showModal: false,
        }
    },
    methods: {
        close: function() {
            this.showModal = false;
        }
    },
    computed: {
        totalValue : function() {
            let total = 0 
            for (let i = 0; i < this.data.products.length; i++)
            {
                let p = this.data.products[i];
                total += p.amount * p.product.price;
            }
            return   (Math.round(total * 100) * 0.01).toLocaleString('en-US', {
                style: 'currency',
                currency: 'GBP',
            });
        }
    },
}
</script>

<style>

</style>