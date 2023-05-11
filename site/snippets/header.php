<?php
/**
 * =============================================================================
 * Header snippet for all pages
 * 
 * Uses “header.controller.php” via the Kirby Snippet Controller plugin
 * Plugin details: https://github.com/lukaskleinschmidt/kirby-snippet-controller
 * 
 * Variables form controller:
 * - $pageLanguageCode
 * - pageLanguageLocale
 * - $metaTitle
 * - $metaDescription
 * - $socialShareTitleOutput
 * - $socialShareDescriptionOutput
 * - $twitterSiteHandle
 * - $twitterCreatorHandle
 * =============================================================================
 */
?>
<!DOCTYPE html>
<html class="no-js" lang="<?= $pageLanguageCode ?>">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= $metaTitle ?></title>
    <?php if (strlen($metaDescription) > 0): ?>
      <meta name="description" content="<?= $metaDescription ?>" />
    <?php endif; ?>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#000000" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Change “no-js” class in <html> to “js” if JavaScript is enabled -->
    <script>
      (function (H) {
        H.className = H.className.replace(/\bno-js\b/, "js");
      })(document.documentElement);
    </script>

    <?= css("assets/css/main.css") ?>

    <!-- Open Graph Data -->
    <meta property="og:title" content="<?= $socialShareTitleOutput ?>" />
    <?php if (strlen($socialShareDescriptionOutput) > 0): ?>
      <meta property="og:description" content="<?= $socialShareDescriptionOutput ?>" />
    <?php endif; ?>
    <!-- <meta property="og:image" content="[Insert URL of image with 2:1 ratio]" /> -->
    <meta property="og:locale" content="<?= $pageLanguageLocale ?>" />

    <!-- Twitter Data -->
    <meta name="twitter:card" content="summary_large_image" />
    <?php if (strlen($twitterSiteHandle) > 0): ?>
      <meta name="twitter:site" content="<?= $twitterSiteHandle ?>" />
    <?php endif; ?>
    <?php if (strlen($twitterCreatorHandle) > 0): ?>
      <meta name="twitter:creator" content="<?= $twitterCreatorHandle ?>" />
    <?php endif; ?>
    <meta name="twitter:title" content="<?= $socialShareTitleOutput ?>" />
    <?php if (strlen($socialShareDescriptionOutput) > 0): ?>
      <meta name="twitter:description" content="<?= $socialShareDescriptionOutput ?>" />
    <?php endif; ?>
    <!-- <meta name="twitter:image" content="[Insert URL of image with 2:1 ratio]" /> -->
  </head>
  <body class="flex flex-col min-h-screen">
