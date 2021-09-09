<template>
  <table class="table table-secondary table-striped">
      <thead>
      <tr>
          <td v-for="head in header" :key="head" class="text-center">
              {{head}}
          </td>
      </tr>
      </thead>
      <tbody>
          <slot></slot>
      </tbody>

  </table>
</template>

<script>

export default {
    props: ['header'],
}
</script>

<style scoped>
    table {
        border-radius: 10px;
        overflow: hidden;
    }
</style>