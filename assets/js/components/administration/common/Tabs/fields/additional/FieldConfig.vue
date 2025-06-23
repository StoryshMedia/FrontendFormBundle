<template>
  <div>
    <div
      v-for="(item, itemIndex) of configuration"
      :key="itemIndex"
    >
      <p
        class="mt-3 mb-1 pl-2 text-sm font-bold"
      >
        {{ $t(itemIndex) }}
      </p>
      <div v-if="itemIndex !== 'values'">
        <field
          :edit-allowed="true"
          :field-string="'Text'"
          :item-value="item"
          :field-placeholder="itemIndex"
          @updateValue="setFieldValue($event, itemIndex)"
        />
      </div>
      <div v-else>
        <field-selection-value
          :values="[...item]"
          @updateValues="setFieldValue($event, itemIndex)"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
const Field = defineAsyncComponent(() =>
  import("@SmugAdministration/js/components/common/Tabs/fields/Field.vue" /* webpackChunkName: "field" */)
);
const FieldSelectionValue = defineAsyncComponent(() =>
  import("./FieldSelectionValue.vue" /* webpackChunkName: "dynamic-form-field-config-value" */)
);

export default {
  name: "FieldConfig",
  components: {
    Field,
    FieldSelectionValue
  },
  props: {
    field:{
      type: Object,
      required: false,
      default: () => ({})
    }
  },
  data() {
    return {
      configuration: {}
    };
  },
  mounted() {
    if (this.field.fieldConfiguration !== null) {
      this.configuration = this.field.fieldConfiguration;
    }
  },
  methods: {
    setFieldValue(event, identifier) {
      this.configuration[identifier] = event;
      this.$emit(
        'updateConfig',
        this.configuration
      );
    }
  }
}
</script>