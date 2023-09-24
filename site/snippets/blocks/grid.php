<?php
/**
 * =============================================================================
 * Grid Block Snippet
 * =============================================================================
 */

/**
 * -----------------------------------------------------------------------------
 * Configuration
 * -----------------------------------------------------------------------------
 */

// Set column width classes for the “1/1”, “1/2” and “1/3” options of the
// respective layout settings field using Tailwind CSS classes
$gridColumnWidthClasses = [
  "1/1" => "col-span-full",
  "1/2" => "col-span-3",
  "1/3" => "col-span-2",
];

/**
 * -----------------------------------------------------------------------------
 * Output
 * -----------------------------------------------------------------------------
 */

// Get the “selectable background colors” array from the site constants
$selectableBackgroundColors = option("site-constants")[
  "selectable-background-colors"
];

// Loop through all grid layout rows
foreach ($block->grid()->toLayouts() as $gridLayoutRow): ?>

  <?php
  // Construct the ID attribute for the current grid row
  $gridRowIdAttribute = $gridLayoutRow->gridRowId()->isNotEmpty()
    ? " id=\"{$gridLayoutRow->gridRowId()}\""
    : "";

  // Set the gap related CSS class for the current grid row
  $gridRowGapClass =
    option("site-constants")["spacing-utility-classes"]["gap"][
      (string) $gridLayoutRow->gridRowGap()
    ] ?? "gap-0";

  // Set the top padding related CSS class for the current grid row
  $gridRowPaddingTopClass =
    option("site-constants")["spacing-utility-classes"]["padding-top"][
      (string) $gridLayoutRow->gridRowPaddingTop()
    ] ?? "pt-0";

  // Set the bottom padding related CSS class for the current grid row
  $gridRowPaddingBottomClass =
    option("site-constants")["spacing-utility-classes"]["padding-bottom"][
      (string) $gridLayoutRow->gridRowPaddingBottom()
    ] ?? "pb-0";

  // Set the start padding related CSS class for the current grid row
  $gridRowPaddingStartClass =
    option("site-constants")["spacing-utility-classes"]["padding-start"][
      (string) $gridLayoutRow->gridRowPaddingStart()
    ] ?? "ps-0";

  // Set the end padding related CSS class for the current grid row
  $gridRowPaddingEndClass =
    option("site-constants")["spacing-utility-classes"]["padding-end"][
      (string) $gridLayoutRow->gridRowPaddingEnd()
    ] ?? "pe-0";

  // Set the background color related CSS class for the current grid row
  $gridRowBackgroundColorClasses = $gridLayoutRow
    ->gridRowBackgroundColor()
    ->isNotEmpty()
    ? $selectableBackgroundColors[
        $gridLayoutRow->gridRowBackgroundColor()->value()
      ]["light-tailwindcss-bg-class"] .
      " " .
      $selectableBackgroundColors[
        $gridLayoutRow->gridRowBackgroundColor()->value()
      ]["dark-tailwindcss-bg-class"]
    : "";

  // Construct the classes attribute for the current grid row
  $gridRowClasses = [
    $gridLayoutRow->gridRowClasses(),
    "grid",
    "grid-cols-6",
    $gridRowGapClass,
    $gridRowPaddingTopClass,
    $gridRowPaddingBottomClass,
    $gridRowPaddingStartClass,
    $gridRowPaddingEndClass,
    $gridRowBackgroundColorClasses,
  ];
  $gridRowClassAttribute = "class=\"" . implode(" ", $gridRowClasses) . "\"";
  ?>

  <!-- Grid Row -->
  <div
    data-page-builder-element-type="grid-row"
    <?= $gridRowIdAttribute ?>
    <?= $gridRowClassAttribute ?>
  >
    <?php foreach ($gridLayoutRow->columns() as $gridLayoutColumn): ?>
      <!-- Grid Column -->
      <?php
      $gridColumnClassOutput = "";
      $gridColumnClassOutput .=
        $gridColumnWidthClasses[$gridLayoutColumn->width()] ?? "col-span-full";
      if ($gridLayoutRow->gridRowBackgroundColor()->isNotEmpty()) {
        $gridColumnInnerContainerClassOutput =
          " " .
          $selectableBackgroundColors[
            $gridLayoutRow->gridRowBackgroundColor()->value()
          ]["light-contrast-tailwindcss-prose-class"] .
          " " .
          $selectableBackgroundColors[
            $gridLayoutRow->gridRowBackgroundColor()->value()
          ]["dark-contrast-tailwindcss-prose-class"];
      } else {
        $gridColumnInnerContainerClassOutput =
          " prose-neutral dark:prose-invert";
      }
      if ($gridLayoutRow->gridRowVerticalAlign()->isNotEmpty()) {
        switch ($gridLayoutRow->gridRowVerticalAlign()->value()) {
          case "top":
            $gridColumnClassOutput .= " flex flex-col justify-start";
            break;
          case "middle":
            $gridColumnClassOutput .= " flex flex-col justify-center";
            break;
          case "bottom":
            $gridColumnClassOutput .= " flex flex-col justify-end";
            break;
        }
      } else {
        $gridColumnClassOutput .= " flex flex-col justify-start";
      }
      ?>
      <div data-page-builder-element-type="grid-column" class="<?= $gridColumnClassOutput ?>">
        <?php if ($gridLayoutColumn->blocks()->isNotEmpty()) {
          echo "<!-- Inner grid column container -->\n<div data-page-builder-element-type=\"grid-inner-column-container\" class=\"max-w-none prose" .
            $gridColumnInnerContainerClassOutput .
            "\">";
        } ?>
          <?php foreach ($gridLayoutColumn->blocks() as $block) {
            if (in_array($block->type(), ["image"])) {
              snippet("blocks/" . $block->type(), [
                "block" => $block,
                "layoutColumnWidth" => $layoutColumnWidth ?? null,
                "gridLayoutColumnWidth" => $gridLayoutColumn->width(),
                "layoutColumnSplitting" => $layoutColumnSplitting,
              ]);
            } else {
              echo $block;
            }
          } ?>
        <?= $gridLayoutColumn->blocks()->isNotEmpty() ? "</div>" : "" ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?>
