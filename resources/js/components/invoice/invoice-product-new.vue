<template>
    <tr>
        <td>
            <Multiselect @selected='selected' class="w-100" :options="allproducts"></Multiselect>
        </td>
        <td>
            <input class="form-control" type="number" name="amount" v-model="data.amount">
        </td>
        <td>
            <button @click="createProduct" class="btn btn-success" :disabled="updateLocked"><i class="fas fa-plus"></i></button>
        </td>
    </tr>
</template>

<script>
import Multiselect from 'vue-simple-search-dropdown';
export default {
    props : ['v-model','allproducts','updateLocked'],
    data : function () {
        return {
            data : this['vModel'],
        }
    },
    methods: {
        selected: function(selected) 
        {
            this.data.productid = selected.id;
        },
        createProduct: function()
        {
            this.$emit("Create")
        }
    },
    components: {
        Multiselect,
    }
}
</script>

<style>

</style>