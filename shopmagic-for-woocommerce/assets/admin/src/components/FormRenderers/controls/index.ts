import {
  and,
  isBooleanControl,
  isDateTimeControl,
  isNumberControl,
  isOneOfControl,
  isAnyOfControl,
  isScoped,
  isStringControl,
  isTimeControl,
  type JsonFormsRendererRegistryEntry,
  or,
  rankWith,
  resolveSchema,
  schemaTypeIs,
  uiTypeIs,
} from "@jsonforms/core";
import GenericControlRenderer from "./GenericControlRenderer.vue";
import GoogleWorksheetsControlRenderer from "./GoogleWorksheetsControlRenderer.vue";
import ActionControlRenderer from "./ActionControlRenderer.vue";
import MultipleChoiceCheckboxControlRenderer from "./MultipleChoiceCheckboxControlRenderer.vue";
import SelectControlRenderer from "./SelectControlRenderer.vue";
import TimeControlRenderer from "./TimeControlRenderer.vue";
import MediaPickerControlRenderer from "./MediaPickerControlRenderer.vue";
import NumberControlRenderer from "./NumberControlRenderer.vue";
import TextControlRenderer from "./TextControlRenderer.vue";
import EditorControlRenderer from "./EditorControlRenderer.vue";
import CheckboxControlRenderer from "./CheckboxControlRenderer.vue";
import DateTimeControlRenderer from "./DateTimeControlRenderer.vue";
import ManualActionControlRenderer from "./ManualActionControlRenderer.vue";
import PluginModuleRenderer from "./PluginModuleRenderer.vue";
import ButtonControlRenderer from "./ButtonControlRenderer.vue";
import RawHtmlControlRenderer from "./RawHtmlControlRenderer.vue";
import ProductArrayRenderer from "./ProductArrayRenderer.vue";

export const controlRenderers: JsonFormsRendererRegistryEntry[] = [
  {
    renderer: GenericControlRenderer,
    tester: rankWith(1, isStringControl),
  },
  {
    renderer: NumberControlRenderer,
    tester: rankWith(1, isNumberControl),
  },
  {
    renderer: SelectControlRenderer,
    tester: rankWith(2, or(isOneOfControl, isAnyOfControl, schemaTypeIs("array"))),
  },
  {
    renderer: DateTimeControlRenderer,
    tester: rankWith(2, isDateTimeControl),
  },
  {
    renderer: TimeControlRenderer,
    tester: rankWith(2, isTimeControl),
  },
  {
    renderer: CheckboxControlRenderer,
    tester: rankWith(
      3,
      or(isBooleanControl, (uischema, schema, context) => {
        if (!isScoped(uischema)) return false;
        const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
        return elementSchema?.extendedCoerce === true;
      }),
    ),
  },
  {
    renderer: MultipleChoiceCheckboxControlRenderer,
    tester: rankWith(
      3,
      and(schemaTypeIs("array"), (uischema, schema, context) => {
        if (!isScoped(uischema)) return false;
        const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
        return elementSchema?.format === "checkbox";
      }),
    ),
  },
  {
    renderer: PluginModuleRenderer,
    tester: rankWith(3, (uischema, schema, context) => {
      if (!isScoped(uischema)) return false;
      const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
      return elementSchema?.format === "plugin-module";
    }),
  },
  {
    renderer: MediaPickerControlRenderer,
    tester: rankWith(
      2,
      and(isStringControl, (uischema, schema, context) => {
        if (!isScoped(uischema)) return false;
        const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
        return elementSchema?.format === "file";
      }),
    ),
  },
  {
    renderer: EditorControlRenderer,
    tester: rankWith(
      2,
      and(isStringControl, (uischema, schema, context) => {
        if (!isScoped(uischema)) return false;
        const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
        return (
          (elementSchema?.format === "textarea" && elementSchema?.presentation?.type === "rich") ||
          false
        );
      }),
    ),
  },
  {
    renderer: TextControlRenderer,
    tester: rankWith(
      3,
      and(isStringControl, (ui, schema, { rootSchema }) => {
        if (!isScoped(ui)) return false;
        const element = resolveSchema(schema, ui.scope, rootSchema);
        return element?.format === "error";
      }),
    ),
  },
  {
    renderer: ActionControlRenderer,
    tester: rankWith(5, (uischema, schema, context) => {
      if (!isScoped(uischema)) return false;
      const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
      return (
        elementSchema?.format === "action" &&
        typeof elementSchema.presentation.callback !== "undefined"
      );
    }),
  },
  {
    renderer: GoogleWorksheetsControlRenderer,
    tester: rankWith(
      5,
      and(uiTypeIs("Group"), (uischema, schema, { rootSchema }) => {
        if (!isScoped(uischema)) return false;
        const elementSchema = resolveSchema(schema, uischema.scope, rootSchema);
        return elementSchema?.format === "google-sheets";
      }),
    ),
  },
  {
    renderer: ManualActionControlRenderer,
    tester: rankWith(7, (uischema, schema, context) => {
      if (!isScoped(uischema)) return false;
      const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
      return elementSchema?.format === "manual-action" && elementSchema.type === "null";
    }),
  },
  {
    renderer: RawHtmlControlRenderer,
    tester: rankWith(5, (uischema, schema, context) => {
      if (!isScoped(uischema)) return false;
      const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
      return elementSchema?.format === "advertisement";
    }),
  },
  {
    renderer: ButtonControlRenderer,
    tester: rankWith(6, (uischema, schema, context) => {
      if (!isScoped(uischema)) return false;
      const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
      return elementSchema?.format === "button" && elementSchema.type === "null";
    }),
  },
  {
    renderer: ProductArrayRenderer,
    tester: rankWith(
      10,
      and(schemaTypeIs("array"), (uischema, schema, context) => {
        if (!isScoped(uischema)) return false;
        const elementSchema = resolveSchema(schema, uischema.scope, context.rootSchema);
        return elementSchema?.presentation.type === "products";
      }),
    ),
  },
];
