<template>
  <section>
    <div
      v-if="fieldTypes.length > 0"
      class="pr-3"
    >
      <div class="flex justify-end space-x-1 my-5">
        <button
          type="button"
          class="btn btn-primary"
          @click="addField()"
        >
          {{ $t('ADD_FIELD') }}
        </button>
      </div>
      <draggable
        v-model="fields"
        class="list-group bg-white space-y-4"
        ghost-class="ghost"
        :group="{ name: 'fields', transitionMode: true, put: true }"
        :empty-insert-threshold="200"
        :transition-mode="true"
        @change="onOrderChanged()"
      >
        <div
          v-for="(field, fieldIndex) of fields"
          :key="fieldIndex"
        >
          <field-item
            :field="field"
            :field-index="fieldIndex"
            :types="fieldTypes"
            @updateField="setFieldValue($event)"
            @updateConfig="setFieldConfig($event)"
            @deleteField="deleteField($event)"
            @deleteChildField="deleteChildField($event)"
            @addRowField="addRowField($event)"
          />
        </div>
      </draggable>
    </div>
  </section>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { VueDraggableNext } from 'vue-draggable-next';
import ApiService from '@SmugAdministration/js/services/api/api.service';
import ArrayService from '@SmugAdministration/js/services/array/array.service';
const FieldItem = defineAsyncComponent(() =>
  import("./additional/FieldItem.vue" /* webpackChunkName: "dynamic-form-field-item" */)
);

export default {
  name: "FormFields",
  components: {
    FieldItem,
    draggable: VueDraggableNext
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
      fields: [],
      expanded: false,
      fieldTypes: []
    }
  },
  mounted() {
    if (!ArrayService.isArray(this.fieldValue)) {
      for (const [key, value] of Object.entries(this.fieldValue)) {
        this.fields.push(value);
      }
    } else {
      this.fields = this.fieldValue;
    }
    this.getData();
  },
  methods: {
    setFieldValue(event) {
      this.fields[event.index][event.identifier] = event.value;
      this.$emit('updateValue', this.fields);
    },
    setFieldConfig(event) {
      this.fields[event.index][event.identifier] = event.value;
      this.$emit('updateValue', this.fields);
    },
    deleteField(event) {
      ApiService.put(
        '/be/api/smug/frontendForm/formField/delete',
        event.item
      ).then(result => {
        this.fields.splice(event.index, 1);
        this.$emit('updateValue', this.fields);
      });
    },
    deleteChildField(event) {
      ApiService.put(
        '/be/api/smug/frontendForm/formField/delete',
        event.item
      ).then(result => {
        this.fields[event.index].children.splice(event.childIndex, 1);
        this.$emit('updateValue', this.fields);
      });
    },
    getData() {
      this.isLoading = true;
      ApiService.get('/be/api/custom/form/field/types').then(result => {
        this.fieldTypes = result;
        this.isLoading = false;
      });
    },
    onOrderChanged() {
      for (let i = 0; i <= this.fields.length - 1; i++) {
        this.fields[i].position = i;
      }
    },
    addField() {
      this.isLoading = true;
      const lastElement = ArrayService.getLastObjectElement(this.fields);
      ApiService.post(
        '/be/api/smug/frontendForm/formField/add',
        {
          type: '',
          identifier: '',
          parentId: '',
          position: (lastElement === null) ? 0 : lastElement.position + 1,
          label: 'NEW_FIELD',
          form: {
            id: this.baseId
          }
        }
      ).then(result => {
        this.fields.push((result.data) ? result.data : result);
        this.$emit('updateValue', this.fields);
        this.isLoading = false;
      });
    },
    addRowField(event) {
      this.isLoading = true;
      ApiService.post(
        '/be/api/smug/frontendForm/formField/add',
        {
          type: '',
          identifier: '',
          parentId: event.item.id,
          position: event.item.children.length,
          label: 'NEW_FIELD',
          form: {
            id: this.baseId
          }
        }
      ).then(result => {
        this.fields[event.index].children.push((result.data) ? result.data : result);
        this.$emit('updateValue', this.fields);
        this.isLoading = false;
      });
    },
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