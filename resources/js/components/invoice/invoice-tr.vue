<template>
  <tr>
        <td class="text-center align-middle">{{data.id}}</td>
        <td class="text-center align-middle">{{data.created_at.substr(0, data.created_at.indexOf('T'))}}</td>
        <td class="text-center align-middle">{{data.dueDate}}</td>
        <td class="text-center align-middle">{{data.billToName}}</td>
        <td class="text-center align-middle">{{totalValue}}</td>
        <td class="text-center align-middle actionsTd">
            <viewButton :invoice="data"></viewButton>
            <editButton :invoice="data"></editButton>
            <button type="button" class="btn btn-danger" v-on:click="show = true">Delete</button>
        </td>
  </tr>
</template>

<script>
import viewButton from './invoice-view-button.vue';
import editButton from './invoice-edit-button.vue';
export default {
    components: {viewButton,editButton},
    props: ['invoice'],
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
                total += p.amount * p.product.price;
            }
            return   (Math.round(total * 100) * 0.01).toLocaleString('en-US', {
                style: 'currency',
                currency: 'GBP',
            });
        }
    },
    methods: {
    }
}
</script>

<style scoped>
    .actionsTd{
        width: 25%;
    }
</style>