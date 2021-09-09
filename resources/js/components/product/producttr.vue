<template>
  <tr>
      <td class="text-center align-middle">{{id}}</td>
      <td class="text-center align-middle">{{title}}</td>
      <td class="text-center align-middle">{{price}}</td>
      <td class="text-center align-middle">
          <button type="button" class="btn btn-primary">Edit</button>
          <button type="button" class="btn btn-danger">Delete</button>
      </td>
  </tr>
</template>

<script>
export default {
  props: ['id','title','price']
}
</script>

<style>

</style>