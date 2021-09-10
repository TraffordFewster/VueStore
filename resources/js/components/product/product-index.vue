<template>
    <div>
        <product-create @new="newProduct"></product-create>
        <input v-model="search" class="form-control mt-2" type="search" placeholder="Search" aria-label="Search">
        <ttable class="w-100 mt-2" :header='["#", "Title", "Price", "Actions"]'>
            <slot></slot>
            <product-tr v-for="product in results" :key="product.id"
                :id="product.id"
                :title="product.name"
                :price="product.price">
            </product-tr>
        </ttable>
    </div>
</template>

<script>
export default {
    props: ['products'],
    data: function() {
        return {
            newProducts : this.products,
            search: "",
        }
    },
    methods: {
        newProduct: function (data) {
            this.newProducts.push(data)
        }
    },
    computed: {
        results: function() {
            if (this.search.length > 0)
            {
                let results = this.newProducts.filter(prod => prod.name.toLowerCase().includes(this.search.toLowerCase()));
                return results;
            } else {
                return this.newProducts
            }
        }
    }
}
</script>

<style>

</style>