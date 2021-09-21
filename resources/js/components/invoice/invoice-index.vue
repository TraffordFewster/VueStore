<template>
    <div>
        <invoiceCreate @created='newInvoice' :allproducts='allproducts'></invoiceCreate>
        <div class="mt-2 d-flex align-middle">
            <span class="d-flex align-middle">
                <filterButton @change="filters.overdue = !filters.overdue" filterName="Overdue" type="danger" :model="filters.overdue"></filterButton>
                <filterButton @change="filters.over10k = !filters.over10k" filterName="> £10,000" type="success" :model="filters.over10k"></filterButton>
                <filterButton @change="filters.archived = !filters.archived" filterName="Archived" type="info" :model="filters.archived"></filterButton>
            </span>
            <span style="margin-left:auto; flex: 1;">
                <input v-model="filters.search" placeholder="Search..." type="text" class="form-control ml-auto" style="width:100%">
            </span>
        </div>
        <ttable class="mt-2" :header='["#", "Created", "Due", "Payee","Value","Actions"]'>
            <invoicetr @remove="remove" v-for="invoice in filteredData" :key="invoice.id" :invoice="invoice" :allproducts="allproducts"></invoicetr>
        </ttable>
    </div>
</template>

<script>
import invoicetr from './invoice-tr.vue';
import invoiceCreate from './invoice-create-button.vue'
import filterButton from './invoice-filter-button.vue'
export default {
    props: ['invoices','allproducts'],
    data: function () {
        return {
            data: this.invoices,
            filters: {
                overdue: false,
                over10k: false,
                archived: false,
            }
        }
    },
    computed:{
        filteredData: function() {
            let fData = this.data
            if (this.filters.overdue){
                let today = new Date()
                fData = fData.filter((invoice) => {
                    let d = new Date(invoice.dueDate)
                    if (d < today) return true;
                    return false;
                })
            }

            if (this.filters.over10k)
            {
                fData = fData.filter((invoice) => {
                    if (this.totalInvoice(invoice) >= 10000) return true;
                    return false;
                })
            }

            if (this.filters.search)
            {
                fData = fData.filter((invoice) => {
                    let search = this.filters.search.toLowerCase()
                    return invoice.billToName.toLowerCase().includes(search) || invoice.id.toString().toLowerCase().includes(search) || invoice.billToAddr1.toLowerCase().includes(search) || invoice.billToAddr2.toLowerCase().includes(search)
                })
            }

            if (!this.filters.archived){
                fData = fData.filter((invoice) => {
                    return !invoice.archived;
                })
            }

            return fData;

        },
    },
    components: {invoicetr,invoiceCreate,filterButton},
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
        },
        newInvoice: function(data)
        {
            this.data.push(data);
        },
        getProduct: function(id){
            for (let p in this.allproducts){
                if (this.allproducts[p].id == id)
                {
                    return this.allproducts[p];
                }
            }
        },
        totalInvoice: function(invoice)
        {
            let total = 0 
            for (let i = 0; i < invoice.products.length; i++)
            {
                let p = invoice.products[i];
                total += p.amount * this.getProduct(p.product_id).price;
            }
            return Math.round(total * 100) * 0.01
        }
    }
}
</script>

<style>

</style>