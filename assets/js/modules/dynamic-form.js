import DynamicForm from '../components/elements/plugin/form/DynamicForm.vue';
import VueModule from '@core/js/modules/vue-module.js';

VueModule.init(
  'dynamic-form',
  DynamicForm,
  {useStore: true, provideDataset: true, identifier: 'dynamic-form'}
);