import type { Ref } from "vue";
import { unref } from "vue";
import { useWpFetch } from "@/composables/useWpFetch";

type MaybeRef<T> = Ref<T> | T;

export async function get<T>(
  url: MaybeRef<string>,
  options?: RequestInit,
): Promise<T> {
  const { data, error } = useWpFetch<T>(url).json({ signal: options?.signal });
  if (error.value) {
    throw new Error(error.value);
  }
  return unref(data);
}
