<template>
  <section>
    <div
      class="pr-3"
    >
      <div
        v-for="(result, resultIndex) of results"
        :key="resultIndex"
      >
        <result-item
          :result="result"
        />
      </div>
    </div>
  </section>
</template>

<script>
import { defineAsyncComponent } from "vue";
import ArrayService from '@SmugAdministration/js/services/array/array.service';
const ResultItem = defineAsyncComponent(() =>
  import("./additional/ResultItem.vue" /* webpackChunkName: "dynamic-form-result-item" */)
);

export default {
  name: "FormResults",
  components: {
    ResultItem,
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
      results: [],
      expanded: false
    }
  },
  mounted() {
    if (!ArrayService.isArray(this.fieldValue)) {
      for (const [key, value] of Object.entries(this.fieldValue)) {
        this.results.push(value);
      }
    } else {
      this.results = this.fieldValue;
    }
  },
  methods: {
    isDisabled() {
      if (this.editAllowed === false) {
        return true;
      }
      if (this.fieldConfig.disabled && this.fieldConfig.disabled === true) {
        return true;
      }
    }
  }
}
</script>