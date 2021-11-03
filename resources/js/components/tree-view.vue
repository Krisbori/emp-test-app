<template>
  <ul>
    <div :class="{ bold: isFolder }" @click="toggle">
        <span v-if="isFolder">{{ isOpen ? "-" : "+" }}</span>
        {{ item.name }}
    </div>
    <ul v-show="isOpen" v-if="isFolder">
      <tree-view
        class="item"
        v-for="(child, index) in item.children"
        :key="index"
        :item="child"
      ></tree-view>
    </ul>
  </ul>
</template>

<style scoped>
.item {
  cursor: pointer;
}
ul {
  padding-left: 1em;
  line-height: 1.5em;
  list-style-type: dot;
}
</style>

<script>
export default {
    name:'tree-view',
        props: {
          item: Object
        },
        data: function () {
          return {
            isOpen: false
          };
        },
        computed: {
          isFolder: function () {
            return this.item.children && this.item.children.length;
          }
        },
        methods: {
          toggle: function () {
            if (this.isFolder) {
              this.isOpen = !this.isOpen;
            }
          }}
};
</script>

<style>
</style>