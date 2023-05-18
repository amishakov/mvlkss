/**
 * =============================================================================
 * Print links as footnotes
 * =============================================================================
 */

/**
 * -----------------------------------------------------------------------------
 * Main function
 * -----------------------------------------------------------------------------
 */

function printLinksAsFootnotes(
  linksContainerSelector,
  footnotesContainerClassName = "print-links-footer",
  printOnlyClassName = "print-only",
  footnotesHeadlineElement = "h3",
  footnotesHeadlineText = "Links",
  referenceTextBeforeNumber = "[",
  referenceTextAfterNumber = "]"
) {
  // Cancel if no links container selector was provided or if no links container
  // was found
  if (!linksContainerSelector) return;
  const linksContainer = document.querySelector(linksContainerSelector);
  if (!linksContainer) return;

  // Get links and process them
  const links = getLinks(linksContainerSelector);
  const processedLinks = processLinks(
    links,
    printOnlyClassName,
    referenceTextBeforeNumber,
    referenceTextAfterNumber
  );

  // Cancel if no links were found
  if (processedLinks.length == 0) return;

  // Create footnotes container and list
  const footnotesContainer = createFootnotesContainer(
    footnotesContainerClassName,
    printOnlyClassName,
    footnotesHeadlineElement,
    footnotesHeadlineText
  );
  const footnotesList = document.createElement("ol");
  footnotesList.classList.add("print-links-footer-list");

  // Add footnotes to the list
  processedLinks.forEach(({ url, isDuplicate }) => {
    if (!isDuplicate) {
      footnotesList.appendChild(createFootnoteListItem(url));
    }
  });

  // Append footnotes list to the container and add it to the body
  footnotesContainer.appendChild(footnotesList);
  document.body.appendChild(footnotesContainer);
}

/**
 * -----------------------------------------------------------------------------
 * Helper functions
 * -----------------------------------------------------------------------------
 */

// Create the footnotes container with a headline
function createFootnotesContainer(
  className,
  printOnlyClassName,
  headlineElement,
  headlineText
) {
  const container = document.createElement("section");
  container.classList.add(className, printOnlyClassName);
  container.innerHTML = `<${headlineElement}>${headlineText}</${headlineElement}>`;
  return container;
}

// Get all links that match the selector and do not start with “#”, “mailto”, or
// “javascript”
function getLinks(selector) {
  return Array.from(
    document.querySelectorAll(
      `${selector} a[href]:not([href^='#']):not([href^="mailto"]):not([href^="javascript"])`
    )
  );
}

// Process the links, add reference numbers and return an array of processed
// links
function processLinks(links, printOnlyClassName, beforeNumber, afterNumber) {
  const urlMap = new Map();

  return links
    .filter((link) => link.getElementsByTagName("img").length < 1)
    .map((link) => {
      const url = link.href;
      let refNumber = urlMap.get(url);
      const isDuplicate = refNumber !== undefined;

      if (!isDuplicate) {
        refNumber = urlMap.size + 1;
        urlMap.set(url, refNumber);
      }

      // Create and insert the reference number
      const reference = createReference(
        refNumber,
        printOnlyClassName,
        beforeNumber,
        afterNumber
      );
      link.parentNode.insertBefore(reference, link.nextSibling);

      return { url, isDuplicate };
    });
}

// Create a reference element with the provided number and text
function createReference(number, className, beforeText, afterText) {
  const reference = document.createElement("sup");
  reference.classList.add(className);
  reference.textContent = `${beforeText}${number}${afterText}`;
  return reference;
}

// Create a list item for the footnote with the provided URL
function createFootnoteListItem(url) {
  const listItem = document.createElement("li");
  listItem.textContent = url;
  return listItem;
}

/**
 * -----------------------------------------------------------------------------
 * Apply main function
 * -----------------------------------------------------------------------------
 */

printLinksAsFootnotes(".js-page-main-content");