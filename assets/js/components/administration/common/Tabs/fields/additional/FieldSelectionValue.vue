<template>
  <div>
    <div class="flex justify-end space-x-1 my-5">
      <button
        type="button"
        class="btn btn-primary"
        @click="addValue()"
      >
        {{ $t('ADD_VALUE') }}
      </button>
    </div>
    <div>
      <draggable
        v-model="fieldValues"
        class="list-group bg-white space-y-4"
        ghost-class="ghost"
        :group="{ name: 'values', transitionMode: true, put: true }"
        :empty-insert-threshold="200"
        :transition-mode="true"
        @change="onOrderChanged()"
      >
        <div
          v-for="(value, valueIndex) of values"
          :key="valueIndex"
          class="flex items-center"
        >
          <div class="flex-1 pr-2">
            <field
              :edit-allowed="true"
              :field-string="'Text'"
              :item-value="value.value"
              :field-placeholder="'VALUE'"
              @updateValue="setValue($event, valueIndex)"
            />
          </div>
          <div class="flex-none w-6 text-center">
            <icon
              class="transform transition duration-300 text-primary"
              :icon-string="'IconMenuDragAndDrop'"
            />
          </div>
          <div class="flex-none w-6 text-center">
            <icon
              class="transform transition duration-300 text-danger"
              :icon-string="'IconMinusCircle'"
            />
          </div>
        </div>
      </draggable>
    </div>
  </div>
</template>

<script>
import { defineAsyncComponent } from "vue";
import { VueDraggableNext } from 'vue-draggable-next';
const Field = defineAsyncComponent(() =>
  import("@SmugAdministration/js/components/common/Tabs/fields/Field.vue" /* webpackChunkName: "field" */)
);
const Icon = defineAsyncComponent(() =>
  import("@core/js/icons/Icon.vue" /* webpackChunkName: "icon" */)
);

export default {
  name: "FieldSelectionValue",
  components: {
    Field,
    Icon,
    draggable: VueDraggableNext
  },
  props: {
    values:{
      type: Object,
      required: false,
      default: () => ({})
    }
  },
  data() {
    return {
      fieldValues: {}
    };
  },
  mounted() {
    this.fieldValues = this.values;
  },
  methods: {
    addValue() {
      this.fieldValues.push({
        position: this.fieldValues.length,
        title: "",
        value: ""
      });
      this.$emit(
        'updateValues',
        this.fieldValues
      );
    },
    onOrderChanged() {
      for (let i = 0; i <= this.fieldValues.length - 1; i++) {
        this.fieldValues[i].position = i;

        if (i === this.fieldValues.length - 1) {
          this.$emit(
            'updateValues',
            this.fieldValues
          );
        }
      }
    },
    setValue(event, index) {
      this.fieldValues[index].title = event;
      this.fieldValues[index].value = event;
      this.$emit(
        'updateValues',
        this.fieldValues
      );
    }
  }
}
</script>