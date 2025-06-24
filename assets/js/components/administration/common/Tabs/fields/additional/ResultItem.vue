<template>
  <div>
    <div class="transition-all duration-200 bg-white border border-gray shadow-lg cursor-pointer hover:bg-gray-50">
      <button
        type="button"
        class="flex items-center justify-between w-full p-4"
        :class="{ 'text-primary': expanded === true, 'text-dark': expanded === false }"
        @click="handleAccordionClick()"
      >
        <span class="flex text-lg font-semibold text-black">{{ result.data.date }}</span>
        <icon
          class="transform transition duration-300"
          :icon-string="'IconCaretDown'"
          :class="'w-4 h-5 flex-none'"
        /> 
      </button>
    </div>
    <vue-collapsible :is-open="expanded === true">
      <div class="pt-1 pb-3 px-2 border-t border-gray">
        <table class="w-full text-sm text-left text-gray-400">
          <thead class="text-xs">
            <tr>
              <th>
                <span class="font-bold">{{ $t('FIELD') }}</span>
              </th>
              <th>
                <span class="font-bold">{{ $t('ANSWER') }}</span>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(value, valueIndex) of result.data"
              :key="valueIndex"
            >
              <td>
                {{ valueIndex }}
              </td>
              <td>
                {{ value }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </vue-collapsible>
  </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
import VueCollapsible from 'vue-height-collapsible/vue3';
const Icon = defineAsyncComponent(() =>
  import("@core/js/icons/Icon.vue" /* webpackChunkName: "icon" */)
);

export default {
  name: "ResultItem",
  components: {
    VueCollapsible,
    Icon
  },
  props: {
    result:{
      type: Object,
      required: false,
      default: () => ({})
    }
  },
  data() {
    return {
      expanded: false
    };
  },
  mounted() {
    delete this.result.data.form;
  },
  methods: {
    handleAccordionClick() {
      this.expanded = !this.expanded;
    },
    getIconClass() {
      return (this.expanded === true) ? 'rotate-180' : '';
    }
  }
}
</script>