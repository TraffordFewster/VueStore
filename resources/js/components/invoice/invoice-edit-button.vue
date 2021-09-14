<template>
  <span>
      <button type="button" class="btn btn-warning" v-on:click="showModal = true">Edit</button>
      <tmodal :show="showModal" :title="'Edit Invoice #'+invoice.id" @close="close" :large="true">
            <form>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label :for="data.id + 'name'" class="form-label">Bill To</label>
                        <input :id="data.id + 'name'" type="text" class="form-control" v-model="data.billToName">
                    </div>
                    <div class="mb-3">
                        <label :for="data.id + 'addr'" class="form-label">Address</label>
                        <input :id="data.id + 'addr'" type="text" class="form-control mb-1" v-model="data.billToAddr1">
                        <input :id="data.id + 'addr2'" type="text" class="form-control" v-model="data.billToAddr2">
                    </div>
                    <div class="mb-3">
                        <label :for="data.id + 'addr'" class="form-label">Due Date</label>
                        <datepicker input-class='form-control' :disabled-dates="{days:[0,6]}" v-model="data.dueDate" style="color:black"></datepicker>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Update</button>
                </div>
            </form>
            <div class="modal-footer">
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
                                {{product.product.name}}    
                            </td>
                            <td class="align-middle">
                                <input class="form-control" type="number" name="amount" v-model="product.amount">
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-success"><i class="fas fa-save"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <Multiselect class="w-100" :options="allproducts"></Multiselect>
                            </td>
                            <td>
                                <input class="form-control" type="number" name="amount" v-model="newproduct.amount">
                            </td>
                            <td>
                                <button class="btn btn-success"><i class="fas fa-plus"></i></button>
                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
      </tmodal>
  </span>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import Multiselect from 'vue-simple-search-dropdown';
export default {
    props: ['invoice','allproducts'],
    data: function () {
        return {
            data: {...this.invoice},
            showModal: false,
            newproduct: {},
        }
    },
    methods: {
        close: function() {
            this.data = {...this.invoice}
            this.showModal = false;
        }
    },
    components: {
        Datepicker,
        Multiselect
    }
}
</script>

<style>

</style>