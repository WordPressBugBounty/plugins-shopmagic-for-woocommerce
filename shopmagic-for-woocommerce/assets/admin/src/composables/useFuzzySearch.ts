import Fuse from "fuse.js";
import { h, isRef, ref, unref, watch, type Ref } from "vue";
import { elementsAsOptions } from "@/_utils";
import { NText, type SelectRenderLabel, type SelectRenderTag } from "naive-ui";
import type { AutomationConfig, AutomationConfigElement } from "@/types/automationConfig";

type MaybeRef<T> = Ref<T> | T;
type SearchOption = AutomationConfig & {
  description?: string;
  group?: string;
};

export const useFuzzySearch = (options: MaybeRef<readonly SearchOption[] | undefined>) => {
  const getOptions = (): SearchOption[] => [...(unref(options) || [])];
  const toSelectOptions = (items: SearchOption[]) =>
    elementsAsOptions(items as AutomationConfigElement[]);
  const optionsRef = ref(toSelectOptions(getOptions()));

  const fuse = new Fuse(getOptions(), {
    keys: ["label", { name: "description", weight: 0.8 }],
    ignoreLocation: true,
  });

  if (isRef(options)) {
    watch(options, (o) => {
      const nextOptions = o || [];
      fuse.setCollection(nextOptions);
      optionsRef.value = toSelectOptions([...nextOptions]);
    });
  }

  // @todo debounce minimally
  function search(pattern: string) {
    if (pattern === "") {
      reset();
    } else {
      const search = fuse.search(pattern);
      optionsRef.value = toSelectOptions(search.map((match) => ({ ...match.item })));
    }
  }

  function reset() {
    optionsRef.value = toSelectOptions(getOptions());
  }

  const renderLabel: SelectRenderLabel = (option) => {
    if (option.type === "group") return String(option.label || "");
    return h("div", { className: "flex flex-col max-w-[550px] my-2 gap-1" }, [
      h("div", String(option?.label || "")),
      h(NText, { depth: 3, tag: "div" }, { default: () => String(option?.description || "") }),
    ]);
  };

  const renderTag: SelectRenderTag = ({ option }) => {
    return h("div", String(option.label || ""));
  };

  return {
    search,
    reset,
    matches: optionsRef,
    renderLabel,
    renderTag,
  };
};
