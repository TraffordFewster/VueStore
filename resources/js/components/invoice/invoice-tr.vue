<template>
  <tr>
      <td class="text-center align-middle">{{data.id}}</td>
      <td class="text-center align-middle">{{data.created_at.substr(0, data.created_at.indexOf('T'))}}</td>
      <td class="text-center align-middle">{{data.dueDate}}</td>
      <td class="text-center align-middle">{{data.billToName}}</td>
      <td class="text-center align-middle">{{totalValue}}</td>
      <td class="text-center align-middle actionsTd">
            <button type="button" class="btn btn-primary" v-on:click="show = true">View</button>
            <button type="button" class="btn btn-warning" v-on:click="show = true">Edit</button>
            <button type="button" class="btn btn-danger" v-on:click="show = true">Delete</button>
            <button type="button" class="btn btn-success" v-on:click="show = true">Send</button>
      </td>
  </tr>
</template>

<script>
export default {
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