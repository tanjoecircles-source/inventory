---
name: Tanjoe Specialty Coffee Marketplace
colors:
  surface: '#fbf9f5'
  surface-dim: '#dbdad6'
  surface-bright: '#fbf9f5'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f5f3ef'
  surface-container: '#efeeea'
  surface-container-high: '#eae8e4'
  surface-container-highest: '#e4e2de'
  on-surface: '#1b1c1a'
  on-surface-variant: '#5d3f3c'
  inverse-surface: '#30312e'
  inverse-on-surface: '#f2f0ed'
  outline: '#926f6b'
  outline-variant: '#e7bdb8'
  surface-tint: '#c00018'
  primary: '#be0017'
  on-primary: '#ffffff'
  primary-container: '#e62129'
  on-primary-container: '#ffffff'
  inverse-primary: '#ffb3ac'
  secondary: '#595f65'
  on-secondary: '#ffffff'
  secondary-container: '#dde3eb'
  on-secondary-container: '#5f656c'
  tertiary: '#006b49'
  on-tertiary: '#ffffff'
  tertiary-container: '#00875d'
  on-tertiary-container: '#ffffff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#ffdad6'
  primary-fixed-dim: '#ffb3ac'
  on-primary-fixed: '#410003'
  on-primary-fixed-variant: '#93000f'
  secondary-fixed: '#dde3eb'
  secondary-fixed-dim: '#c1c7ce'
  on-secondary-fixed: '#161c22'
  on-secondary-fixed-variant: '#41474e'
  tertiary-fixed: '#6ffbbe'
  tertiary-fixed-dim: '#4edea3'
  on-tertiary-fixed: '#002113'
  on-tertiary-fixed-variant: '#005236'
  background: '#fbf9f5'
  on-background: '#1b1c1a'
  surface-variant: '#e4e2de'
typography:
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 30px
    fontWeight: '700'
    lineHeight: 38px
  headline-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 20px
    fontWeight: '700'
    lineHeight: 28px
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 16px
    fontWeight: '700'
    lineHeight: 22px
  body-lg:
    fontFamily: Inter
    fontSize: 15px
    fontWeight: '400'
    lineHeight: 22px
  body-md:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  body-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 16px
  label-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 18px
  label-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
  label-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
    letterSpacing: 0.02em
  price-tag:
    fontFamily: Plus Jakarta Sans
    fontSize: 15px
    fontWeight: '700'
    lineHeight: 20px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 0.75rem
  gutter-mobile: 0.5rem
  margin: 1rem
  margin-mobile: 0.75rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 0.75rem
  space-lg: 1rem
  space-xl: 1.5rem
---

## Brand & Style

The design system is crafted for an artisanal specialty coffee e-commerce experience tailored for modern mobile shoppers. It merges the warmth, authenticity, and sensory richness of craft roasting with the lightning-fast, high-converting utility of contemporary Southeast Asian mobile marketplaces.

### Design Movement: Modern Warm Tactility & Clean Commerce
- **Atmospheric Palette:** Warm roasted brown hues paired with an inviting cream canvas evoke the physical experience of a third-wave coffee bar without feeling heavy or dated.
- **Scannable Micro-Hierarchies:** Compact product cards with clear categorical badges, high-contrast statuses (Ready vs. Sold Out), and direct conversion affordances (such as one-tap WhatsApp orders and quick-view specifications).
- **Target Audience:** Discerning home baristas, café owners, and specialty coffee enthusiasts seeking detailed provenance data (origin, elevation, process, varietal) delivered through clean, frictionless touchpoints.

## Colors

The palette establishes an artisanal yet highly legible commerce experience:

- **Primary (`#E62129` - Vibrant Red Brand Accent):** Serves as the primary brand anchor, active tab indicators, and interactive highlights.
- **Secondary (`#343A40` - Slate Dark Neutral):** Used for primary typography, card headings, and deep grounding surfaces that demand strong contrast.
- **Tertiary (`#10B981` - Emerald Ready):** Signals immediate availability, in-stock bean statuses, and instant WhatsApp ordering triggers.
- **Error / Stock Out (`#EF4444` - Crimson Sold Out):** High-visibility pill indicators to instantly communicate sold-out harvest lots.
- **Neutral Canvas (`#FDFBF7` - Warm Cream Off-White):** Replaces clinical pure whites with an organic, milk-and-paper cream canvas to enhance visual comfort during extended browsing sessions.
- **Surface Elevation Cards (`#FFFFFF`):** Crisp pure white card tiles resting above the cream canvas to maximize product readability.

## Typography

The typographic hierarchy combines the friendly, geometric structure of **Plus Jakarta Sans** for headlines, prices, and conversion buttons with the functional legibility of **Inter** for technical bean specifications:

- **Headlines & Product Names:** Plus Jakarta Sans provides clean, contemporary visual weight that keeps product titles legible even when displaying long descriptive names (e.g., *Seasonal - Mosto Washed Bodjongwaroe 200gr*).
- **Technical Specs & Origin Data:** Inter renders metadata tables (Origin, Elevation, Varietal, Process, Processor) with crisp tabular precision.
- **Price Tags:** Emphasized with bold weights in Plus Jakarta Sans (`price-tag`) to ensure financial clarity at a glance.

## Layout & Spacing

The layout is built around mobile-first utility, calibrated for quick vertical scanning:

- **Grid Architecture:** 4-column layout on mobile devices (`<640px`) shifting to a 12-column system on tablets and desktop viewports.
- **Margin Rhythm:** A safe outer canvas margin of `12px` (mobile) to `16px` (tablet) keeps cards comfortably bounded within thumb reach.
- **Internal Card Density:** Compact component padding (`space-md` = 12px) maximizes the number of visible coffee listings per screenfold without causing visual fatigue.
- **Vertical Flow:** Standardized `12px` vertical stack between product listings, paired with horizontal scrolling segmented category filter tabs (`Filter`, `Espresso`, `Seasonal`).

## Elevation & Depth

Visual hierarchy uses warm, diffuse ambient shadows to lift pure white product cards smoothly off the cream `#FDFBF7` canvas:

- **Ground Level (Base Canvas):** `#FDFBF7` flat backdrop with zero elevation.
- **Level 1 (Product Cards & List Items):** `#FFFFFF` fill with an ultra-soft tinted shadow: `0 2px 8px -2px rgba(52, 58, 64, 0.06), 0 1px 3px 0 rgba(52, 58, 64, 0.04)`. A subtle hairline border (`1px solid rgba(230, 33, 41, 0.08)`) defines boundary edges cleanly.
- **Level 2 (Expanded Specs & Dropdowns):** Subtle recessed background (`#F9F6F0`) inside cards for technical tables, creating nested depth without heavy box borders.
- **Level 3 (Sticky CTAs & Floating Filter Bars):** `0 8px 20px -4px rgba(52, 58, 64, 0.12)`, grounding bottom action sheets, floating cart buttons, and WhatsApp order triggers.

## Shapes

The design uses a roundedness level of `2` to balance modern approachable aesthetics with structural commerce discipline:

- **Base Cards & Modals:** Standardized corner radius of `16px` (`rounded-lg` / `1rem`), delivering the friendly modern feel of top-tier consumer apps.
- **Action Buttons & Inputs:** `8px` (`0.5rem`) corner radius for crisp, reliable touch boundaries.
- **Status Badges & Pills:** Fully rounded capsule/pill shapes (`rounded-full` / `9999px`) for stock indicators (`Ready`, `Sold Out`) and category chips.
- **Thumbnail Placeholders:** `10px` rounded corners matching the inner contours of card containers.

## Components

### 1. Product Cards & Accordion Details
- **Collapsible Master Tile:** White rounded card container (`16px` radius) housing product title, origin subtitle, formatted price (`Rp 130.000`), status pill, and secondary detail button.
- **Spec Grid Panel:** Collapsible drawer revealing a 2-column key-value matrix (Origin, Elevation, Varietal, Process, Processor, Harvest) alongside a 4:5 coffee thumbnail.
- **Price Matrix Tier:** Alternate packaging tiers (e.g., *Retail 1 Pack* vs. *Bundling 2 Pack*) presented in high-contrast alternating rows with soft highlight tints (`#FDF2F8` or `#FEF3C7`).

### 2. Status Badges & Pills
- **Ready Badge:** Capsule pill featuring `#10B981` background, white label, and a checkmark icon prefix (`Ready`).
- **Sold Out Badge:** Crimson capsule (`#EF4444`) with white typography and a circular cross icon prefix (`Sold Out`).
- **New Tag:** Subdued italicized amber text (`#D97706`) placed immediately beside the product title.

### 3. Action Buttons
- **Direct WhatsApp Order CTA:** Full-width `#10B981` filled button with rounded `8px` corners, white bold text, and a WhatsApp icon prefix.
- **More Info Toggle:** Dark slate/coffee (`#374151` or `#343A40`) filled micro-button with rounded `6px` radius and info icon.
- **Primary Marketplace CTA:** Solid `#E62129` with `#FFFFFF` text and subtle press-state scale effect (0.98x).

### 4. Category Segmented Controls & Tabs
- Clean horizontal segmented bar featuring an underline indicator or active pill in `#E62129`.
- Unselected tabs maintain high-contrast dark neutral tones (`#6B7280`) on the cream backdrop.

### 5. Form Elements & Quantity Selectors
- Pill-shaped stepper controls (`-` / `+`) using warm gray background fills (`#F3F4F6`) with dark coffee icons.
- Input fields framed with a soft border (`1.5px solid rgba(230, 33, 41, 0.15)`) that transitions to primary `#E62129` on active focus.