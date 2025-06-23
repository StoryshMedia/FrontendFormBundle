<template>
  <multiselect
    v-model="selectValues"
    :options="options"
    :multiple="true"
    :searchable="false"
    :close-on-select="false"
    :show-labels="false"
    :placeholder="$t('PLEASE_CHOOSE')"
    :aria-label="$t('PLEASE_CHOOSE')"
    @select="setContent"
  >
    <template #caret="{ toggle }">
      <div>
        <div
          class="multiselect__select"
          @mousedown.prevent.stop="toggle()"
        >
          <icon 
            class="transform transition duration-300"
            :icon-string="'IconCaretDown'"
            :class="'w-4 h-5 flex-none'"
          />
        </div>
      </div>
    </template>
  </multiselect>
</template>
  
<script>
import { defineAsyncComponent } from "vue";
import Multiselect from 'vue-multiselect';
const Icon = defineAsyncComponent(() =>
  import("@core/js/icons/Icon.vue" /* webpackChunkName: "icon" */)
);

export default {
  name: "MultiSelect",
  components: {
    Multiselect,
    Icon
  },
  props: {
    editAllowed:{
      type: Boolean,
      required: true
    },
    fieldValue:{
      type: String,
      required: false,
      default: ''
    },
    baseId:{
      type: String,
      required: false,
      default: null
    },
    fieldConfig:{
      type: Object,
      required: false,
      default: () => ({})
    },
    fieldPlaceholder:{
      type: String,
      required: false,
      default: 'TEXT_PLACEHOLDER'
    }
  },
  data() {
    return {
      options: [],
      selectValues: [],
      formValue: []
    };
  },
  created() {
    for (let i = 0; i <= this.fieldConfig.values.length - 1; i++) {
      this.options.push(this.fieldConfig.values[i].value);
    }
  },
  methods: {
    setContent(option) {
      this.$emit('updateValue', this.selectValues.toString());
    }
  }
}
</script>