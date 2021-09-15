<template>
    <div>
        <invoiceCreate :allproducts='allproducts'></invoiceCreate>
        <ttable class="mt-2" :header='["#", "Created", "Due", "Payee","Value","Actions"]'>
            <invoicetr @remove="remove" v-for="invoice in data" :key="invoice.id" :invoice="invoice" :allproducts="allproducts"></invoicetr>
        </ttable>
    </div>
</template>

<script>
import invoicetr from './invoice-tr.vue';
import invoiceCreate from './invoice-create-button.vue'
export default {
    props: ['invoices','allproducts'],
    data: function () {
        return {
            data: this.invoices,
        }
    },
    components: {invoicetr,invoiceCreate},
    methods: {
        remove: function(id)
        {
            for (let i in this.data)
            {
                console.log(i)
                if (this.data[i].id == id)
                {
                    this.data.splice(i,1);
                    break;
                }
            }
        }
    }
}
</script>

<style>

</style>