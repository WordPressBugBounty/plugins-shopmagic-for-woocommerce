<script setup lang="ts">
import { ref, h, computed, onBeforeUnmount } from "vue";
import { NH1, NH2, NP, useMessage } from "naive-ui";
import NotificationMessage from "@/components/NotificationMessage.vue";
import AutomationPrompt from "../components/GenerativeContent/AutomationPrompt.vue";
import AutomationResult from "../components/GenerativeContent/AutomationResult.vue";
import PromptSuggestions from "../components/GenerativeContent/PromptSuggestions.vue";
import type { Automation } from "@/types/automation";
import { __ } from "../../../plugins/i18n";
import { useFetch } from "@vueuse/core";
import { useSingleAutomation } from "@/app/automations/singleAutomation";
import { useRouter } from "vue-router";

const API_BASE_URL = "https://api.shopmagic.app/v1";

async function sendBeacon(endpoint: string, data: object) {
  const url = `${API_BASE_URL}${endpoint}`;

  try {
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      mode: 'no-cors',
      body: JSON.stringify(data),
      keepalive: true
    });
  } catch (error) {
    // ignore
  }
}


const { addAutomation, save } = useSingleAutomation();
const router = useRouter();
const message = useMessage();

const userMessage = ref("");
const isGenerating = ref(false);
const generatedAutomation = ref<Automation | null>(null);
const generatedDescription = ref("");
const generatedAutomationUuid = ref<string | null>(null);
const userVote = ref<number | null>(null);
const automationSaved = ref(false);
const isInitialState = ref(true);

// Before unmount to prevent accidental navigation
onBeforeUnmount(() => {
  window.removeEventListener("beforeunload", preventUnload);
});

// Prevent closing the window with unsaved automation
function preventUnload(e) {
  if (generatedAutomation.value && !automationSaved.value) {
    e.preventDefault();
    e.returnValue = ""; // Chrome requires returnValue to be set
    return ""; // This message may be shown in some browsers
  }
}

const waitingMessages = [
  __("Thinking about your automation...", "shopmagic-for-woocommerce"),
  __("Crafting your automation...", "shopmagic-for-woocommerce"),
  __("Generating the perfect automation for you...", "shopmagic-for-woocommerce"),
  __("Working on your request...", "shopmagic-for-woocommerce"),
  __("Almost there, creating your automation...", "shopmagic-for-woocommerce"),
];

function getRandomWaitingMessage() {
  const randomIndex = Math.floor(Math.random() * waitingMessages.length);
  return waitingMessages[randomIndex];
}

function handleSuggestionSelect(suggestion: string) {
  userMessage.value = suggestion;
}

async function sendMessage() {
  if (!userMessage.value.trim() || isGenerating.value) return;

  const prompt = userMessage.value;
  isGenerating.value = true;
  isInitialState.value = false;

  const { data, statusCode, error } = await useFetch(`${API_BASE_URL}/automations/completion`, {options: {mode: 'no-cors'}})
    .post({
      prompt,
      language: window.ShopMagic.locale,
      extensions: window.ShopMagic.modules,
      url: window.ShopMagic.homeUrl,
      email: window.ShopMagic.user.email,
    })
    .json();

  isGenerating.value = false;

  if (error.value) {
    generatedDescription.value = __(
      "Sorry, I couldn't generate an automation. Please try again.",
      "shopmagic-for-woocommerce",
    );
    generatedAutomation.value = null;
    console.error("API Error:", statusCode.value, data.value);
    return;
  }

  if (Array.isArray(data.value?.content)) {
    // Check if we have an automation type in the content
    const automationContent = data.value.content.find((item) => item.type === "automation");
    const textContents = data.value.content.filter((item) => item.type === "text");

    // Combine all text content parts into a single description
    const combinedDescription =
      textContents.length > 0 ? textContents.map((item) => item.text).join("\n\n") : "";

    if (automationContent) {
      // Successful automation generation
      try {
        generatedAutomation.value = JSON.parse(automationContent.text);
        generatedDescription.value =
          combinedDescription ||
          __("Your automation was generated successfully.", "shopmagic-for-woocommerce");

        // Store the UUID for voting
        generatedAutomationUuid.value = data.value.uuid || null;

        // Add event listener to prevent accidental navigation
        window.addEventListener("beforeunload", preventUnload);
      } catch (parseError) {
        console.error("Error parsing automation data:", parseError);
        generatedDescription.value =
          combinedDescription ||
          __(
            "Received a response but couldn't create an automation. Please try again.",
            "shopmagic-for-woocommerce",
          );
        generatedAutomation.value = null;
      }
    } else if (textContents.length > 0) {
      // Only text was returned (error from API)
      generatedDescription.value = combinedDescription;
      generatedAutomation.value = null;
    } else {
      // No valid content found
      generatedDescription.value = __(
        "Received an empty response. Please try again.",
        "shopmagic-for-woocommerce",
      );
      generatedAutomation.value = null;
    }
  } else {
    // Invalid response format
    generatedDescription.value = __(
      "Received an invalid response. Please try again.",
      "shopmagic-for-woocommerce",
    );
    generatedAutomation.value = null;
  }
}

function resetChat() {
  userMessage.value = "";
  generatedAutomation.value = null;
  generatedDescription.value = "";
  generatedAutomationUuid.value = null;
  userVote.value = null;
  automationSaved.value = false;
  window.removeEventListener("beforeunload", preventUnload);

  // Animate back to initial state
  setTimeout(() => {
    isInitialState.value = true;
  }, 100); // Small delay for animation
}

function confirmReset() {
  if (generatedAutomation.value && !automationSaved.value) {
    if (
      confirm(
        __(
          "Are you sure you want to start a new automation? Your current unsaved automation will be lost.",
          "shopmagic-for-woocommerce",
        ),
      )
    ) {
      // Track the "reset" action before resetting
      if (generatedAutomationUuid.value) {
        sendBeacon(`/automations/${generatedAutomationUuid.value}/track`, {
          action: 'reset',
          saved: false
        });
      }
      resetChat();
    }
  } else {
    // Track the "reset" action for saved or empty state
    if (generatedAutomationUuid.value) {
      sendBeacon(`/automations/${generatedAutomationUuid.value}/track`, {
        action: 'reset',
        saved: automationSaved.value
      });
    }
    resetChat();
  }
}

async function openAutomation() {
  const m = message.loading(__("Saving automation", "shopmagic-for-woocommerce"), {
    duration: 0,
    keepAliveOnHover: true,
  });

  generatedAutomation.value.name = generatedAutomation.value.name + " (#ShopWizard)";
  addAutomation(generatedAutomation.value);

  try {
    const id = await save();
    if (!id) return;
    m.content = () =>
      h(NotificationMessage, { title: __("Automation saved", "shopmagic-for-woocommerce") });
    m.type = "success";

    automationSaved.value = true;
    window.removeEventListener("beforeunload", preventUnload);

    // Track the "open" action
    if (generatedAutomationUuid.value) {
      sendBeacon(`/automations/${generatedAutomationUuid.value}/track`, {
        action: 'open',
        automationId: id.value
      });
    }

    router.push({
      name: "automation",
      params: {
        id: id.value,
      },
    });
  } catch (e) {
    m.content = () =>
      h(NotificationMessage, {
        title: e.message,
        message: typeof e.cause === "string" ? e.cause : undefined,
      });
    m.type = "error";

    // Track the save error
    if (generatedAutomationUuid.value) {
      sendBeacon(`/automations/${generatedAutomationUuid.value}/track`, {
        action: 'save_error',
        error: e.message,
        errorDetails: typeof e.cause === "string" ? e.cause : undefined,
      });
    }
  } finally {
    m.closable = true;
    setTimeout(m.destroy, 4500);
  }
}

function vote(isPositive) {
  const voteValue = isPositive ? 1 : -1;

  if (userVote.value === voteValue) {
    userVote.value = null;
  } else {
    userVote.value = voteValue;
  }

  if (!generatedAutomationUuid.value) {
    console.error("Cannot vote: missing automation UUID");
    return;
  }

  // Send vote using track endpoint with beacon API for reliable delivery
  const success = sendBeacon(`/automations/${generatedAutomationUuid.value}/track`, {
    action: 'vote',
    vote: voteValue,
  });

  if (success) {
    console.log("Vote tracking beacon sent successfully:", voteValue);
  } else {
    console.error("Failed to send vote tracking beacon");
  }
}

const showVotingButtons = computed(() => generatedAutomation.value !== null);
const isPositiveVoteActive = computed(() => userVote.value === 1);
const isNegativeVoteActive = computed(() => userVote.value === -1);
const showMainContent = computed(
  () => isInitialState.value || (!isGenerating.value && generatedDescription.length === 0),
);
</script>

<template>
  <div class="shopmagic-wizard-container" :class="{ 'initial-state': isInitialState }">
    <div class="shopmagic-prompt-area" :class="{ compact: !isInitialState }">
      <transition name="fade">
        <div v-if="isInitialState" class="initial-heading">
          <NH2>{{ __("What can I help you automate?", "shopmagic-for-woocommerce") }}</NH2>
        </div>
      </transition>

      <AutomationPrompt
        v-model:value="userMessage"
        :disabled="isGenerating || generatedDescription.length > 0"
        @submit="sendMessage"
      />
      <p :style="{ color: 'rgb(118, 124, 130)' }">
        {{
          __(
            "Please note that ShopWizard has no access to your store's specific configuration and product data. As a result, the suggested automations might require adjustments to perfectly fit your needs.",
            "shopmagic-for-woocommerce",
          )
        }}
      </p>

      <transition name="fade">
        <PromptSuggestions
          v-if="isInitialState"
          :disabled="isGenerating || generatedDescription.length > 0"
          @select="handleSuggestionSelect"
        />
      </transition>
    </div>

    <AutomationResult
      v-if="isGenerating || generatedDescription.length > 0"
      :isLoading="isGenerating"
      :description="generatedDescription"
      :automation="generatedAutomation"
      :userVote="userVote"
      :waitingMessage="getRandomWaitingMessage()"
      @open="openAutomation"
      @reset="confirmReset"
      @vote="vote"
    />
  </div>
</template>

<style scoped>
.shopmagic-wizard-container {
  max-width: 800px;
  margin: 0 auto;
  transition: all 1s ease;
}

.initial-state {
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 65vh;
}

.shopmagic-prompt-area {
  margin-bottom: 20px;
  transition: all 0.7s ease;
}

.shopmagic-prompt-area.compact {
  margin-bottom: 30px;
  transition: all 0.7s ease;
}

.initial-heading {
  text-align: center;
  margin-bottom: 20px;
}

.fade-enter-active,
.fade-leave-active {
  transition:
    opacity 0.3s,
    transform 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
