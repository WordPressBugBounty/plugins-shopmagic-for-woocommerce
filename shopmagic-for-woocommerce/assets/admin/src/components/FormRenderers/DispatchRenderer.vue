<template>
  <component :is="determinedRenderer" v-bind="renderer">
    <!-- Forward all slots dynamically -->
    <template v-for="(_, slotName) in $slots" :key="slotName" #[slotName]>
      <slot :name="slotName"></slot>
    </template>
  </component>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { UnknownRenderer, rendererProps, useJsonFormsRenderer } from "@jsonforms/vue";
import maxBy from "lodash/maxBy";

export default defineComponent({
  name: "DispatchRenderer",
  props: {
    ...rendererProps(),
  },
  setup(props) {
    return useJsonFormsRenderer(props);
  },
  computed: {
    determinedRenderer(): any {
      const testerContext = {
        rootSchema: this.rootSchema,
        config: this.config,
      };
      const renderer = maxBy(this.renderer.renderers, (r) =>
        r.tester(this.renderer.uischema, this.renderer.schema, testerContext),
      );
      if (
        renderer === undefined ||
        renderer.tester(this.renderer.uischema, this.renderer.schema, testerContext) === -1
      ) {
        // return UnknownRenderer;
      } else {
        return renderer.renderer;
      }
    },
  },
});
</script>
