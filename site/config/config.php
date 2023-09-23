<?php

/**
 * =============================================================================
 * General Kirby Configuration
 * =============================================================================
 */

/**
 * -----------------------------------------------------------------------------
 * Thumbnail Srcsets and Presets
 * -----------------------------------------------------------------------------
 */

// CONFIGURATION: Set the widths of the thumbnails
$thumbWidths = [200, 400, 600, 800, 1000, 1600, 2000];

// CONFIGURATION: Define the sets of srcsets with their respective settings
//
// Keep an eye on the order of the sets. The same order will be used for the
// source elements in the HTML. Browsers will use the first source element that
// they support. I.e. if you want to prioritize AVIF over WebP, the AVIF
// configuration for a specific input type must come before the WebP
// configuration for the same input type.
//
// For each of the sets, a preset will be created in addition to the srcset. The
// preset will not inllude any width information. It will only include the
// format and quality information.
$thumbSrcsetsConfig = [
    [
        "name" => "default",
        "input" => null,
        "format" => null,
        "quality" => 90,
    ],
    [
        "name" => "png->webp",
        "input" => "png",
        "format" => "webp",
        "quality" => 100,
    ],
    [
        "name" => "jpg->avif",
        "input" => "jpg",
        "format" => "avif",
        "quality" => 60,
    ],
    [
        "name" => "jpg->webp",
        "input" => "jpg",
        "format" => "webp",
        "quality" => 70,
    ],
];

// Helper function for constructing the srcsets from a given configuration
function getThumbSrcsets($thumbSrcsetsConfig, $thumbWidths) {
    $thumbSrcsets = [];
    foreach ($thumbSrcsetsConfig as $thumbSrcset) {
        $thumbSrcsets[$thumbSrcset["name"]] = [];
        foreach ($thumbWidths as $thumbWidth) {
            $thumbSrcsets[$thumbSrcset["name"]][(string) $thumbWidth . "w"] = [
                "width" => $thumbWidth,
                "format" => $thumbSrcset["format"] ?? null,
                "quality" => $thumbSrcset["quality"] ?? null,
                "type-attribute-for-source-element" => $thumbSrcset["format"]
                    ? "image/" . $thumbSrcset["format"]
                    : null,
            ];
        }
    }
    return $thumbSrcsets;
}

// Helper function for constructing the srcsets selector from a given
// configuration
function getThumbSrcsetsSelector($thumbSrcsetsConfig) {
    $thumbSrcsetsSelector = [];
    foreach ($thumbSrcsetsConfig as $thumbSrcset) {
        if (!$thumbSrcset["input"]) {
            continue;
        }
        $inputFileExtensions = in_array($thumbSrcset["input"], ["jpg", "jpeg"])
            ? ["jpg", "jpeg"]
            : [$thumbSrcset["input"]];

        foreach ($inputFileExtensions as $inputFileExtension) {
            if (!isset($thumbSrcsetsSelector[$inputFileExtension])) {
                $thumbSrcsetsSelector[$inputFileExtension] = [];
            }
            $thumbSrcsetsSelector[$inputFileExtension][] = $thumbSrcset["name"];
        }
    }
    return $thumbSrcsetsSelector;
}

// Helper function for constructing the presets from a given configuration
function getThumbPresets($thumbSrcsetsConfig) {
    $thumbPresets = [];
    foreach ($thumbSrcsetsConfig as $thumbSrcset) {
        $thumbPresets[$thumbSrcset["name"]] = [
            "format" => $thumbSrcset["format"] ?? null,
            "quality" => $thumbSrcset["quality"] ?? null,
        ];
    }
    return $thumbPresets;
}

// Construct the srcsets and presets from the configuration
$thumbSrcsets = getThumbSrcsets($thumbSrcsetsConfig, $thumbWidths);
$thumbSrcsetsSelector = getThumbSrcsetsSelector($thumbSrcsetsConfig);
$thumbPresets = getThumbPresets($thumbSrcsetsConfig);

/**
 * -----------------------------------------------------------------------------
 * CONFIGURATION: Selectable Background Colors
 *
 * These constants assign Tailwind CSS utility classes to the respective options
 * which are used in panel fields whenever a website editor should be able to
 * choose a background color for a block, button, etc.
 *
 * Colors which are not part of the default Tailwind CSS color palette can be
 * added by defining a custom color in the Tailwind CSS configuration file
 * (tailwind.config.js) and then using the respective utility class here.
 * See https://tailwindcss.com/docs/customizing-colors#adding-additional-colors
 * for more information.
 *
 * The keys of the array are the option values of the panel field. The values of
 * the array are arrays with the following keys:
 * - label: The label text of the option
 * - light-tailwindcss-bg-class: The Tailwind CSS utility class for the light
 *   mode background color (needs to start with “bg-”)
 * - light-tailwindcss-border-class: The Tailwind CSS utility class for the
 *   light mode border color which is used when rendering buttons (needs to
 *   start with “border-”)
 * - light-tailwindcss-prose-class: The Tailwind CSS utility class of the
 *   Typography plugin color scheme used for rendering text on this backgorund
 *   in light mode (needs to start with “prose-”)
 * - dark-tailwindcss-bg-class: The Tailwind CSS utility class for the dark mode
 *   background color (needs to start with “bg-”)
 * - dark-tailwindcss-border-class: The Tailwind CSS utility class for the
 *   dark mode border color which is used when rendering buttons (needs to
 *   start with “border-”)
 * - dark-tailwindcss-prose-class: The Tailwind CSS utility class of the
 *   Typography plugin color scheme used for rendering text on this backgorund
 *   in dark mode (needs to start with “prose-”)
 * -----------------------------------------------------------------------------
 */

$selectableBackgroundColors = [
    "brand-red" => [
        "label" => "Brand Red",
        "light-tailwindcss-bg-class" => "bg-red-300",
        "light-tailwindcss-border-class" => "border-red-300",
        "light-tailwindcss-prose-class" => "prose-black",
        "dark-tailwindcss-bg-class" => "bg-red-700",
        "dark-tailwindcss-border-class" => "border-red-700",
        "dark-tailwindcss-prose-class" => "prose-white",
    ],
    "brand-green" => [
        "label" => "Brand Green",
        "light-tailwindcss-bg-class" => "bg-green-300",
        "light-tailwindcssborder-class" => "border-green-300",
        "light-tailwindcss-prose-class" => "prose-black",
        "dark-tailwindcss-bg-class" => "bg-green-700",
        "dark-tailwindcss-border-class" => "border-green-700",
        "dark-tailwindcss-prose-class" => "prose-white",
    ],
    "brand-blue" => [
        "label" => "Brand Blue",
        "light-tailwindcss-bg-class" => "bg-blue-300",
        "light-tailwindcss-border-class" => "border-blue-300",
        "light-tailwindcss-prose-class" => "prose-black",
        "dark-tailwindcss-bg-class" => "bg-blue-700",
        "dark-tailwindcss-border-class" => "border-blue-700",
        "dark-tailwindcss-prose-class" => "prose-white",
    ],
];

/**
 * -----------------------------------------------------------------------------
 * CONFIGURATION: Spacing Utility Classes
 *
 * These constants assign Tailwind CSS utility classes to the respective options
 * which are used in panel fields whenever a website editor should be able to
 * choose how big a spacing (e.g. margin, padding, gap) should be.
 *
 * There are always the same five options available in the panel fields:
 * - none
 * - small
 * - medium
 * - large
 * - xlarge
 * -----------------------------------------------------------------------------
 */

$spacingUtilityClasses = [
    "margin-top" => [
        "none" => "mt-0",
        "small" => "mt-small",
        "medium" => "mt-medium",
        "large" => "mt-large",
        "xlarge" => "mt-xlarge",
    ],
    "margin-bottom" => [
        "none" => "mb-0",
        "small" => "mb-small",
        "medium" => "mb-medium",
        "large" => "mb-large",
        "xlarge" => "mb-xlarge",
    ],
    "margin-start" => [
        "none" => "ms-0",
        "small" => "ms-small",
        "medium" => "ms-medium",
        "large" => "ms-large",
        "xlarge" => "ms-xlarge",
    ],
    "margin-end" => [
        "none" => "me-0",
        "small" => "me-small",
        "medium" => "me-medium",
        "large" => "me-large",
        "xlarge" => "me-xlarge",
    ],
    "padding-top" => [
        "none" => "pt-0",
        "small" => "pt-small",
        "medium" => "pt-medium",
        "large" => "pt-large",
        "xlarge" => "pt-xlarge",
    ],
    "padding-bottom" => [
        "none" => "pb-0",
        "small" => "pb-small",
        "medium" => "pb-medium",
        "large" => "pb-large",
        "xlarge" => "pb-xlarge",
    ],
    "padding-start" => [
        "none" => "ps-0",
        "small" => "ps-small",
        "medium" => "ps-medium",
        "large" => "ps-large",
        "xlarge" => "ps-xlarge",
    ],
    "padding-end" => [
        "none" => "pe-0",
        "small" => "pe-small",
        "medium" => "pe-medium",
        "large" => "pe-large",
        "xlarge" => "pe-xlarge",
    ],
    "gap" => [
        "none" => "gap-0",
        "small" => "gap-small",
        "medium" => "gap-medium",
        "large" => "gap-large",
        "xlarge" => "gap-xlarge",
    ],
];

/**
 * -----------------------------------------------------------------------------
 * Return Configuration
 * -----------------------------------------------------------------------------
 */

return [
    "afbora.kirby-minify-html.enabled" => true,
    "cache" => [
        "pages" => [
            "active" => true,
        ],
    ],
    "debug" => false,
    "distantnative.retour.logs" => false,
    "languages" => true,
    "markdown" => [
        "extra" => true,
    ],
    "ready" => function ($kirby) {
        // Fetch XML sitemap URLs for robots.txt file
        $sitemapPages = $kirby
            ->site()
            ->index()
            ->filterBy("template", "xml-sitemap");
        $sitemapEntriesForRobotsTxt = [];
        foreach ($sitemapPages as $page) {
            foreach ($kirby->languages() as $language) {
                $sitemapEntriesForRobotsTxt[] =
                    "Sitemap: " . $page->url($language->code()) . ".xml";
            }
        }
        $sitemapContentForRobotsTxt = implode(
            "\n",
            $sitemapEntriesForRobotsTxt
        );

        return [
            "bnomei.robots-txt.content" =>
                "# https://www.robotstxt.org/\n\n# Allow crawling of all content\nUser-agent: *\nDisallow:\n\n" .
                $sitemapContentForRobotsTxt,
            "bnomei.robots-txt.groups" => null,
            "bnomei.robots-txt.sitemap" => null,
        ];
    },
    "site-constants" => [
        "thumb-widths" => $thumbWidths,
        "thumb-srcsets" => $thumbSrcsets,
        "thumb-srcsets-selector" => $thumbSrcsetsSelector,
        "selectable-background-colors" => $selectableBackgroundColors,
        "spacing-utility-classes" => $spacingUtilityClasses,
    ],
    "thumbs" => [
        "driver" => "im",
        "srcsets" => $thumbSrcsets,
        "presets" => $thumbPresets,
    ],
];
