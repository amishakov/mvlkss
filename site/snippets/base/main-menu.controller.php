<?php
/**
 * =============================================================================
 * Controller for Main Menu Snippet (which is used on all pages)
 *
 * Uses the Kirby Snippet Controller plugin
 * Plugin details: https://github.com/lukaskleinschmidt/kirby-snippet-controller
 *
 * Provides variables for use in the header snippet:
 * - $mainMenuItems
 * - $mainMenuOpenLabel
 * - $mainMenuCloseLabel
 * =============================================================================
 */

return function ($kirby, $site, $page) {
  // Construct array with content for main menu
  $mainMenuItems = [];
  foreach ($site->children()->listed() as $menuItem) {
    $menuOptions = $menuItem->includeInMenus()->split(",");
    if (in_array("main", $menuOptions)) {
      $url =
        $menuItem->intendedTemplate() == "custommenuitem"
          ? $menuItem->menuItemUrl()
          : $menuItem->url();
      $mainMenuItems[] = [
        "title" => $menuItem->title(),
        "url" => $url,
        "target" => $menuItem->menuItemTarget()->exists()
          ? $menuItem->menuItemTarget()
          : "_self",
        "isActive" =>
          $page->is($menuItem) || $page->parents()->has($menuItem)
            ? "active"
            : "",
      ];
    }
  }

  return [
    "mainMenuItems" => $mainMenuItems,
    "mainMenuOpenLabel" => $kirby->language()
      ? ($kirby->language()->code() == "de"
        ? "Menü öffnen"
        : "Open menu")
      : "Open menu",
    "mainMenuCloseLabel" => $kirby->language()
      ? ($kirby->language()->code() == "de"
        ? "Menü schließen"
        : "Close menu")
      : "Close menu",
  ];
};