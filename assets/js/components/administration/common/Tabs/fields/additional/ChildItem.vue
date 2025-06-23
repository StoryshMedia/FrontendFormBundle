<template>
  <div>
    <div class="transition-all duration-200 bg-white border border-gray shadow-lg cursor-pointer hover:bg-gray-50">
      <button
        type="button"
        class="flex items-center justify-between w-full p-4"
        :class="{ 'text-primary': expanded === true, 'text-dark': expanded === false }"
        @click="handleAccordionClick()"
      >
        <span class="flex text-lg font-semibold text-black">{{ $t(field.label) }}</span>
        <icon
          class="transform transition duration-300"
          :icon-string="'IconCaretDown'"
          :class="'w-4 h-5 flex-none'"
        /> 
      </button>
    </div>
    <vue-collapsible :is-open="expanded === true">
      <div class="pt-1 pb-3 px-2 border-t border-gray">
        <p
          class="mt-3 mb-1 pl-2 text-sm font-bold"
        >
          {{ $t('REQUIRED') }}
        </p>
        <field
          :edit-allowed="true"
          :field-string="'Checkbox'"
          :item-value="field.required"
          :field-placeholder="'REQUIRED'"
          @updateValue="setFieldValue($event, 'required', fieldIndex)"
        />
        <p
          class="mt-3 mb-1 pl-2 text-sm font-bold"
        >
          {{ $t('TYPE') }}
        </p>
        <field
          :edit-allowed="true"
          :field-string="'Selectbox'"
          :item-value="field.type"
          :field-config="{items: types}"
          :field-placeholder="'TYPE'"
          @updateValue="setFieldValue($event, 'type', fieldIndex)"
        />
        <p
          class="mt-3 mb-1 pl-2 text-sm font-bold"
        >
          {{ $t('LABEL') }}
        </p>
        <field
          :edit-allowed="true"
          :field-string="'Text'"
          :item-value="field.label"
          :field-placeholder="'LABEL'"
          @updateValue="setFieldValue($event, 'label', fieldIndex)"
        />
        <p
          class="mt-3 mb-1 pl-2 text-sm font-bold"
        >
          {{ $t('VALIDATION_TYPE') }}
        </p>
        <field
          :edit-allowed="true"
          :field-string="'Selectbox'"
          :item-value="field.validationType"
          :field-config="{items: validationTypes}"
          :field-placeholder="'VALIDATION_TYPE'"
          @updateValue="setFieldValue($event, 'validationType', fieldIndex)"
        />

        <field-config
          :field="{...field}"
          @updateConfig="updateConfig($event)"
        />
      </div>
    </vue-collapsible>
  </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
import VueCollapsible from 'vue-height-collapsible/vue3';
const Field = defineAsyncComponent(() =>
  import("@SmugAdministration/js/components/common/Tabs/fields/Field.vue" /* webpackChunkName: "field" */)
);
const FieldConfig = defineAsyncComponent(() =>
  import("./FieldConfig.vue" /* webpackChunkName: "form-field-config" */)
);
const Icon = defineAsyncComponent(() =>
  import("@core/js/icons/Icon.vue" /* webpackChunkName: "icon" */)
);

export default {
  name: "FieldItem",
  components: {
    FieldConfig,
    Field,
    VueCollapsible,
    Icon
  },
  props: {
    field:{
      type: Object,
      required: false,
      default: () => ({})
    },
    types:{
      type: Array,
      required: false,
      default: () => ([])
    },
    fieldIndex:{
      type: Number,
      required: false,
      default: 1
    }
  },
  data() {
    return {
      expanded: false,
      fieldTypeConfig: {},
      validationTypes: [
        {
          title: 'E_MAIL',
          value: 'email'
        },
        {
          title: 'NUMBER',
          value: 'number'
        }
      ],
      reload: 0
    };
  },
  created() {
    if (this.field.fieldConfiguration !== null && Object.keys(this.field.fieldConfiguration).length === 0) {
      const type = this.types.find(el => {
        return el.value.identifier == this.field.type;
      });
      
      if (type && type.value) {
        this.field.fieldConfiguration = type.value.config;
        this.fieldTypeConfig = type.value.config;
      }
    }
  },
  methods: {
    setFieldValue(event, identifier, index) {
      if (identifier === 'type') {
        this.fieldType = event.config;
      }
      this.$emit(
        'updateField',
        {
          index: index,
          value: (identifier === 'type') ? event.identifier : event,
          identifier: identifier
        }
      );
    },
    updateConfig(event) {
      this.field.fieldConfiguration = event;
    },
    setChildFieldValue(event, childIndex, index) {
      this.$emit(
        'updateChildField',
        {
          index: index,
          childIndex: childIndex,
          value: event.value,
          identifier: event.identifier
        }
      );
    },
    handleAccordionClick() {
      this.expanded = !this.expanded;
    },
    getRowGridClass() {
      return 'grid-cols-' + this.field.children.length;
    },
    emitDelete() {
      this.$emit(
        'deleteField',
        {
          index: this.fieldIndex,
          item: this.field
        }
      );
    },
    emitChildDelete(child, childIndex) {
      this.$emit(
        'deleteChildField',
        {
          index: this.fieldIndex,
          childIndex: childIndex,
          item: child
        }
      );
    },
    getIconClass() {
      return (this.expanded === true) ? 'rotate-180' : '';
    }
  }
}
</script>