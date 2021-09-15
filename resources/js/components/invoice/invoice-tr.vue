<template>
  <tr>
        <td class="text-center align-middle">{{data.id}}</td>
        <td class="text-center align-middle">{{data.created_at.substr(0, data.created_at.indexOf('T'))}}</td>
        <td class="text-center align-middle">{{dueDate}}</td>
        <td class="text-center align-middle">{{data.billToName}}</td>
        <td class="text-center align-middle">{{totalValue}}</td>
        <td class="text-center align-middle actionsTd">
            <viewButton :invoice="data" :allproducts="allproducts"></viewButton>
            <editButton @editted="edit" :invoice="data" :allproducts="allproducts"></editButton>
            <button type="button" class="btn btn-danger" v-on:click="show = true">Delete</button>
        </td>
  </tr>
</template>

<script>
import viewButton from './invoice-view-button.vue';
import editButton from './invoice-edit-button.vue';
export default {
    components: {viewButton,editButton},
    props: ['invoice','allproducts'],
    data: function () {
        return {
            data : this.invoice,
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
        dueDate : function() {
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
        edit: function (data){
            this.data = data;
        }
    }
}
</script>

<style scoped>
    .actionsTd{
        width: 25%;
    }
</style>