import { controlRenderers } from "@/components/FormRenderers/controls";
import { layoutRenderers } from "@/components/FormRenderers/layouts";

export const naiveUiRenderers = [...controlRenderers, ...layoutRenderers];
