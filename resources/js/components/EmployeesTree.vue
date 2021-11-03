<template>
  <div class="container">
    <h4>Сотрудники</h4>
    <ul>
      <tree class="item" :item="employees"></tree>
    </ul>
  </div>
</template>

<script>
import tree from "./tree-view.vue";

export default {
  components: {
    tree,
  },
  data() {
    return {
      employees: {},
    };
  },
  mounted() {
    axios.get("/api/employees").then((response) => {
      this.employees = response.data.data[0];
    });
  },
};
</script>
