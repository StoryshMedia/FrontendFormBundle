<template>
  <section>
    <component
      :is="componentLoader"
      :field-value="itemValue"
      :field-placeholder="fieldPlaceholder"
      :field-config="fieldConfig"
      :error-text="errorText"
      :object-values="objectValues"
      @update-value="emitData($event, 'updateValue')"
      @refresh-data="emitData($event, 'refreshData')"
    />
  </section>
</template>

<script>
import { defineAsyncComponent } from 'vue'
import * as activeFields from 'Bundle/activeFormFields.json'

export default {
  name: "Field",
  props: {
    editAllowed:{
      type: Boolean,
      required: true
    },
    fieldString:{
      type: String,
      required: true
    },
    itemValue:{
      type: [String, Number, Object, Array, Boolean],
      required: false,
      default: ''
    },
    fieldPlaceholder:{
      type: String,
      required: false,
      default: ''
    },
    fieldConfig:{
      type: Object,
      required: false,
      default: () => ({})
    },
    objectValues:{
      type: Object,
      required: false,
      default: () => ({})
    }
  },
  data() {
    return {
      value: '',
      reload: 0
    }
  },
  computed: {
    componentLoader () {
      const fieldString = this.fieldString.charAt(0).toUpperCase() + this.fieldString.slice(1);
      const field = activeFields[activeFields.findIndex((obj) => obj.name === fieldString)];

      try {
        if (field) {
          return defineAsyncComponent(() => import("../../../../../../../../../../" + field.path + ".vue"));
        } else {
          return '';
        }
      } catch (e) {
        return '';
      }
    }
  },
  methods: {
    emitData(value, eventName) {
      this.$emit(eventName, value);
    }
  }
}
</script>