<script setup lang="ts">
import { computed, useSlots } from "vue";
import DOMPurify from "dompurify";

const htmlContent = computed(() => {
  const markdown = useSlots().default?.()[0]?.children as string;
  if (!markdown) return "";

  // Process the markdown in multiple passes to handle complex formatting correctly
  let html = markdown;

  // First pass: Convert headers
  html = html
    .replace(/^### (.*$)/gim, "<h3>$1</h3>")
    .replace(/^## (.*$)/gim, "<h2>$1</h2>")
    .replace(/^# (.*$)/gim, "<h1>$1</h1>");

  // Parse markdown lists properly with nesting
  html = html.replace(/\r\n|\r/g, "\n");
  
  // Convert the markdown to a structured format we can analyze
  const lines = html.split("\n");
  let result = [];
  
  // Track list state
  let inList = false;
  let listType = null; // 'ol' or 'ul'
  let currentList = [];
  let currentIndent = 0;
  let listStack = [];
  
  // Process each line to build proper HTML lists
  for (let i = 0; i < lines.length; i++) {
    const line = lines[i];
    
    // Check for list items with regex
    const olMatch = line.match(/^(\s*)(\d+)[\.\)]\s+(.*)/);
    const ulMatch = line.match(/^(\s*)[\-\*]\s+(.*)/);
    
    if (olMatch || ulMatch) {
      const match = olMatch || ulMatch;
      const indent = match[1].length;
      const content = olMatch ? olMatch[3] : ulMatch[2];
      const isOrderedList = !!olMatch;
      
      // If we're not in a list yet, start one
      if (!inList) {
        inList = true;
        listType = isOrderedList ? 'ol' : 'ul';
        result.push(`<${listType}>`);
        result.push(`<li>${content}</li>`);
        currentIndent = indent;
      } 
      // We're already in a list
      else {
        // Same indentation level - new item in current list
        if (indent === currentIndent && listType === (isOrderedList ? 'ol' : 'ul')) {
          result.push(`<li>${content}</li>`);
        }
        // New indentation level - start a sublist
        else if (indent > currentIndent) {
          // Remove the closing </li> from the previous item
          result[result.length - 1] = result[result.length - 1].replace('</li>', '');
          
          // Push the current list state onto the stack
          listStack.push({
            type: listType,
            indent: currentIndent
          });
          
          // Start a new list
          listType = isOrderedList ? 'ol' : 'ul';
          result.push(`<${listType}>`);
          result.push(`<li>${content}</li>`);
          currentIndent = indent;
        }
        // Moving back to a previous indentation level
        else if (indent < currentIndent) {
          // Close current lists until we reach the right level
          while (listStack.length > 0) {
            const lastList = listStack.pop();
            
            // Close the current list
            result.push(`</${listType}></li>`);
            
            // Restore previous list state
            listType = lastList.type;
            currentIndent = lastList.indent;
            
            // If we've reached the right indentation level, break
            if (currentIndent <= indent) {
              break;
            }
          }
          
          // Now add the new item to the current list
          result.push(`<li>${content}</li>`);
        }
        // Different list type at same level - close current list, start new one
        else if (indent === currentIndent && listType !== (isOrderedList ? 'ol' : 'ul')) {
          result.push(`</${listType}>`);
          listType = isOrderedList ? 'ol' : 'ul';
          result.push(`<${listType}>`);
          result.push(`<li>${content}</li>`);
        }
      }
    }
    // Not a list item - if we're in a list, end it
    else if (line.trim() !== '') {
      if (inList) {
        // Close all open lists
        while (listStack.length > 0) {
          const lastList = listStack.pop();
          result.push(`</${listType}></li>`);
          listType = lastList.type;
        }
        
        result.push(`</${listType}>`);
        inList = false;
      }
      
      // Add the non-list line
      result.push(line);
    }
    // Empty line - preserve it if we're not in a list
    else if (!inList) {
      result.push(line);
    }
  }
  
  // Close any remaining open lists
  if (inList) {
    while (listStack.length > 0) {
      const lastList = listStack.pop();
      result.push(`</${listType}></li>`);
      listType = lastList.type;
    }
    
    result.push(`</${listType}>`);
  }
  
  // Join everything back together
  html = result.join('\n');

  // Convert code blocks
  html = html.replace(/`([^`]+)`/gim, "<code>$1</code>");

  // Convert bold
  html = html.replace(/\*\*(.*?)\*\*/gim, "<strong>$1</strong>");

  // Convert emphasis (only if not part of a list item marker)
  html = html.replace(/(?<!\*)\*([^\*]+)\*/gim, "<em>$1</em>");

  // Convert links
  html = html.replace(
    /\[([^\]]+)\]\(([^)]+)\)/gim,
    '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>',
  );

  // Apply HTML to non-tag content (paragraphs)
  html = html.replace(/^(?!\s*<[a-z])(.+)$/gim, "<p>$1</p>");
  
  // Fix nesting issues
  html = html.replace(/<li>([^<]*)<ul>/g, '<li>$1<ul>');
  html = html.replace(/<li>([^<]*)<ol>/g, '<li>$1<ol>');
  
  // Remove empty paragraphs
  html = html.replace(/<p>\s*<\/p>/g, '');
  
  // Normalize whitespace
  html = html.replace(/>\s+</g, '><');
  
  // Fix specific case of numbered list items with bullet sublists
  html = html.replace(/<li>([^<]*)<\/li>\s*<ul>/g, '<li>$1<ul>');
  html = html.replace(/<\/ul>\s*<\/li>/g, '</ul></li>');
  
  // Ensure proper nesting of list items
  html = html.replace(/<\/ol><ul>/g, '');
  html = html.replace(/<\/ul><ol>/g, '');
  
  // Sanitize the final HTML
  return DOMPurify.sanitize(html);
});
</script>

<template>
  <div class="markdown-content" v-html="htmlContent" />
</template>

<style scoped>
.markdown-content {
  font-size: 14px;
  line-height: 1.6;
  color: rgb(51, 54, 57);
}

.markdown-content :deep(h1) {
  font-size: 1.8em;
  margin-bottom: 0.8em;
}

.markdown-content :deep(h2) {
  font-size: 1.5em;
  margin-bottom: 0.6em;
}

.markdown-content :deep(h3) {
  font-size: 1.2em;
  margin-bottom: 0.4em;
}

.markdown-content :deep(p) {
  font-size: 1em;
  line-height: 1.6;
}

.markdown-content :deep(ul),
.markdown-content :deep(ol) {
  list-style: revert;
  margin-left: 2em;
  margin-bottom: 1em;
}

.markdown-content :deep(li) {
  margin-bottom: 0.3em;
}

.markdown-content :deep(code) {
  background-color: rgba(0, 0, 0, 0.05);
  padding: 0.2em 0.4em;
  border-radius: 3px;
  font-family: monospace;
}

.markdown-content :deep(a) {
  color: #1976d2;
  text-decoration: none;
}

.markdown-content :deep(a:hover) {
  text-decoration: underline;
}
</style>
