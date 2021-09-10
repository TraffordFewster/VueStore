<template>
    <div>
        <div v-for="error in errs" :key="error[0]">
            <div class="alert alert-danger" role="alert" v-if="error[0] != null">
                <span>{{error[0]}}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['errors'],
    computed: {
        errs: function() {
            return this.errors;
        }
    }
}
</script>

<style>

</style>