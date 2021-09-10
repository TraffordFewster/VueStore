<template>
  <ttable class="mt-2" :header='["#", "Created", "Due", "Payee","Value","Actions"]'>
      <invoicetr v-for="invoice in data" :key="invoice.id" :invoice="invoice"></invoicetr>
  </ttable>
</template>

<script>
import invoicetr from './invoice-tr.vue';
export default {
    props: ['invoices'],
    data: function () {
        return {
            data: this.invoices,
        }
    },
    components: {invoicetr},
}
</script>

<style>

</style>