<template>
    <div class="bg-dark rounded-bottom p-4">


        <h2 class="text-center">Invoices</h2>
        <ttable class="align-middle text-center" :header="['ID', 'Due Date', 'Bill To Name', 'Extra Infomation']">
            <tr v-for="invoice in data" :key="invoice.id">
                <td>{{invoice.id}}</td>
                <td>{{invoice.dueDate}}</td>
                <td>{{invoice.billToName}}</td>
                <td> 
                    <div class="d-grid gap-2">
                        <button @click="selectInvoiceView(invoice)" type="button" class="btn btn-primary">Details</button>
                    </div> 
                </td>
            </tr>
        </ttable>


        <h2 class="text-center">Product Totals</h2>
        <ttable class="align-middle text-center" :header="['ID','Product Name', 'Total', 'Price Per #', 'Total Charged']">
            <tr v-for="product in productTotals" :key="product.id">
                <td>{{product.id}}</td>
                <td>{{product.name}}</td>
                <td>{{product.amount}}</td>
                <td>{{currencyFormat(product.price * 1)}}</td>
                <td>{{currencyFormat(product.price * product.amount)}}</td>
            </tr>
        </ttable>


        <tmodal :show="showModal" @close="showModal = false">
            <div class="modal-body">
                <h4>Invoice #{{selectedInvoice.id}}</h4>
                <hr>
                <h5 class="text-start">{{selectedInvoice.billToName}}</h5>
                <h6 class="text-start">{{selectedInvoice.billToAddr1}}</h6>
                <h6 class="text-start">{{selectedInvoice.billToAddr2}}</h6>
                <br>
                <table class="w-100 table-primary">
                    <tr>
                        <th class="col">Name</th>
                        <th class="col">Price Per</th>
                        <th class="col">Amount</th>
                        <th class="col">Total Due</th>
                    </tr>
                    <tr v-for="product in selectedInvoice.products" :key="product.id">
                        <td>{{product.product.name}}</td>
                        <td>{{currencyFormat(product.product.price)}}</td>
                        <td>{{product.amount}}</td>
                        <td>{{currencyFormat(product.amount * product.product.price)}}</td>
                    </tr>
                    <br>
                    <h6>Total: {{currencyFormat(selectedTotal)}}</h6>
                    <h6 class="text-start">Due: {{selectedInvoice.dueDate}}</h6>
                </table>
            </div>
        </tmodal>


    </div>
</template>

<script>
export default {

    props: ['data'],

    data: function() {
        return {
            selectedInvoice : {},
            showModal: false,
        }
    },

    methods: {
        currencyFormat: function(amount)
        {
            return (amount).toLocaleString('en-GB', {
                style: 'currency',
                currency: 'GBP',
            });
        },
        selectInvoiceView: function(invoice) {
            this.selectedInvoice = invoice
            this.showModal = true
        },
    },

    computed: {
        productTotals: function (){
            let returnData = {}
            for (let i = 0; i < this.data.length; i++) {
                const invoice = this.data[i];
                for (let j = 0; j < invoice.products.length; j++) {
                    const product = invoice.products[j];
                    const id = product.product.id
                    if (!returnData[id]) returnData[id] = {amount: 0 , ...product.product}
                    returnData[product.product.id].amount += product.amount;
                };
            }
            return returnData;
        },
        selectedTotal: function() {
            if (!this.selectedInvoice.products) return 0;
            let total = 0;
            for (let i = 0; i < this.selectedInvoice.products.length; i++) {
                const element = this.selectedInvoice.products[i];
                total += element.amount * element.product.price;
            }
            return total;
        }
    }

}
</script>

<style>

</style>