<template>
    <div class="bg-dark rounded-bottom">
        <div v-for="invoice in data" :key="invoice.id">
            <p>
                {{JSON.stringify(invoice)}}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
}
</script>

<style>

</style>