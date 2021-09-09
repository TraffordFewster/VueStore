<template>
  <div class="mb-3">
        <label :for="type" class="form-label text-left">{{label}}</label>
        <input v-model="binder" :type="type" class="form-control" :id="type">
    </div>
</template>

<script>
export default {
    props: ['label','type','item','bind'],
    data: function () {
        return {
            binder : this.item[this.bind]
        }
    }
}
</script>

<style>

</style>