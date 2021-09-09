<template>
  <tr>
      <td class="text-center align-middle">{{this.item.id}}</td>
      <td class="text-center align-middle">{{this.item.title}}</td>
      <td class="text-center align-middle">{{this.item.price}}</td>
      <td class="text-center align-middle">
          <!-- <button type="button" class="btn btn-primary">Edit</button> -->
          <producteditbutton :item="item" @updated="updated"></producteditbutton>
          <button type="button" class="btn btn-danger">Delete</button>
      </td>
  </tr>
</template>

<script>
import producteditbutton from './product-edit-button.vue';
export default {
  props: ['id','title','price'],
  components: {producteditbutton},
  data: function () {
    return {
      item: {id: this.id, title: this.title, price: this.price}
    }
  },
  methods: {
    updated: function (value) {
      this.item = value;
    }
  }
}
</script>

<style>

</style>