<template>
  <span>
      <button type="button" class="btn btn-warning" v-on:click="showModal = true">Edit</button>
      <tmodal :show="showModal" title="View Invoice" @close="close">
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
                </div>
                <div class="modal-footer">
                </div>
            </form>
      </tmodal>
  </span>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    props: ['invoice'],
    data: function () {
        return {
            data: {...this.invoice},
            showModal: false,
        }
    },
    methods: {
        close: function() {
            this.data = {...this.invoice}
            this.showModal = false;
        }
    },
    components: {
        Datepicker
    }
}
</script>

<style>

</style>