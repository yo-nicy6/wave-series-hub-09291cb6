# Wave-Movies WordPress Theme

A modern, dark-themed WordPress theme for series download websites. Features multiple color themes (Red/Black, Blue/Dark, Purple/Dark), premium animations, and a comprehensive series management system.

## Features

- 🎨 **Three Color Themes**: Red/Black (default), Blue/Dark, Purple/Dark
- 🎯 **Floating Theme Switcher**: Draggable button with localStorage persistence
- ✨ **Premium Animations**: Scroll reveals, tap effects, card hovers, pulse animations
- 📺 **Series Management**: Custom post type with episodes and download links
- 🖼️ **Screenshot Gallery**: Upload multiple screenshots per series
- 📱 **Fully Responsive**: Mobile-first design
- 🔍 **Search Integration**: Series-only search
- 👁️ **View Counter**: Track most viewed series

---

## Installation

### Step 1: Upload Theme

1. Download the `wave-movies` folder
2. Go to **WordPress Admin → Appearance → Themes**
3. Click **Add New → Upload Theme**
4. Upload the `wave-movies.zip` file (or manually upload the folder to `/wp-content/themes/`)
5. Click **Activate**

### Step 2: Auto-Setup

On theme activation, the following happens automatically:

- ✅ Required pages created (Home, About, Search, Download)
- ✅ Home page set as front page
- ✅ Primary navigation menu created
- ✅ Series post type registered
- ✅ Genre taxonomy registered

### Step 3: Verify Setup

1. Visit your site - you should see the Wave-Movies home page
2. Check **Admin → Series** - the Series menu should appear
3. Check **Admin → Pages** - About, Search, Download pages should exist

---

## How to Add Series

### Step 1: Create a New Series

1. Go to **Admin → Series → Add New**
2. Enter the **Title** (e.g., "Breaking Bad")
3. Add the **Description** in the main editor

### Step 2: Set Featured Image (Poster)

1. In the right sidebar, find **Featured Image**
2. Click **Set featured image**
3. Upload or select your series poster (recommended: 400x600px)

### Step 3: Add Screenshots

1. Scroll down to **Screenshots Gallery** meta box
2. Click **Add Screenshots**
3. Upload or select multiple images
4. Click **Add Screenshots** to confirm

### Step 4: Add Series Information

In the **Series Information** sidebar box:
- **Release Year**: Enter the year (e.g., 2008)
- **Rating**: Enter 1-10 rating
- **Status**: Select Ongoing, Completed, or Upcoming

### Step 5: Add Genres (Optional)

1. In the right sidebar, find **Genres**
2. Add new genres or select existing ones

---

## How to Add Download Groups & Episodes

This system allows you to add **multiple download buttons** (e.g., different quality versions like 480p, 720p, 1080p) with each having its own episode list. Everything is managed **within the Series edit page**!

### Understanding Download Groups

A **Download Group** represents a quality variant of your series. For example:
- `Stranger Things 480p [250MB/E]`
- `Stranger Things 720p [480MB/E]`
- `Stranger Things 1080p [1.5GB/E]`

Each group has:
- A **Name** (displayed on the download button)
- Its own **Episode List** with individual download links

### Adding Download Groups

1. Edit your Series post
2. Scroll to **Episodes & Download Links** meta box
3. Click **Add Download Group**
4. Enter a descriptive name, e.g., `720p Hindi-English [480MB/E]`

### Adding Episodes to a Download Group

1. Inside the download group, click **Add Episode**
2. Fill in:
   - **Episode Title**: e.g., "Episode 1" or "S01E01 - Pilot"
   - **Download Link**: Paste the full URL
3. Repeat for each episode
4. Click **Update** to save

### How It Displays

- On the series page, each download group shows as a separate button with the group name
- When users click a download button, they're taken to a **dynamically generated episodes page** for that specific quality
- Each episodes page shows only the episodes from that download group
- Users can switch between quality versions using the "Other Quality Versions" section

### Example Structure

```
Breaking Bad (Series)
├── Download Group: "480p [250MB/E]"
│   ├── Episode 1 → https://link1.com/480p/ep1
│   ├── Episode 2 → https://link1.com/480p/ep2
│   └── Episode 3 → https://link1.com/480p/ep3
│
├── Download Group: "720p [500MB/E]"
│   ├── Episode 1 → https://link1.com/720p/ep1
│   ├── Episode 2 → https://link1.com/720p/ep2
│   └── Episode 3 → https://link1.com/720p/ep3
│
└── Download Group: "1080p [1.2GB/E]"
    ├── Episode 1 → https://link1.com/1080p/ep1
    ├── Episode 2 → https://link1.com/1080p/ep2
    └── Episode 3 → https://link1.com/1080p/ep3
```

### Managing Download Groups

- **Collapse/Expand**: Click the arrow button to hide/show episodes
- **Remove Group**: Click the trash icon (confirms before deleting)
- **Remove Episode**: Click the X button on any episode row
- **Reorder**: Remove and re-add groups/episodes as needed

---

## Theme Switcher

### How It Works

- A floating button appears in the bottom-right corner
- Click to reveal theme options:
  - 🔴 **Red / Black** (Default)
  - 🔵 **Blue / Dark**
  - 🟣 **Purple / Dark**
- Selection persists via localStorage
- Button is **draggable** - position also saves to localStorage

### Customization

To add more themes, edit `style.css`:

```css
[data-theme="green"] {
    --wm-primary: #22c55e;
    --wm-primary-hover: #16a34a;
    --wm-primary-glow: rgba(34, 197, 94, 0.4);
    --wm-secondary: #166534;
    --wm-card-glow: rgba(134, 239, 172, 0.15);
}
```

Then add a button in `footer.php`:

```php
<button class="wm-theme-option" data-theme="green">
    <span class="wm-theme-swatch" style="background: linear-gradient(135deg, #22c55e, #166534);"></span>
    <?php _e('Green / Dark', 'wave-movies'); ?>
</button>
```

---

## File Structure

```
wave-movies/
├── style.css                 # Main stylesheet with CSS variables
├── functions.php             # Theme setup, CPT, meta boxes
├── header.php                # Site header with search
├── footer.php                # Footer with theme switcher
├── index.php                 # Home page (series grid)
├── single-series.php         # Single series template
├── archive-series.php        # Series archive
├── search.php                # Search results
├── page-about.php            # About page template
├── page-search.php           # Search page template
├── page-download.php         # Download redirect page
├── template-parts/
│   └── episodes-list.php     # Episodes list partial
├── assets/
│   ├── js/
│   │   └── animations.js     # Theme switcher & animations
│   └── images/
│       └── placeholder-poster.jpg
└── README.md                 # This file
```

---

## Animation System

### CSS Animations (style.css)

| Class | Effect |
|-------|--------|
| `.wm-scroll-animate` | Fade in on scroll |
| `.wm-tap-animate` | Scale on tap/click |
| `.wm-stagger > *` | Stagger children animations |
| `.wm-animate-fade-in` | Simple fade in |
| `.wm-animate-scale-in` | Scale up entrance |

### JavaScript (animations.js)

The JS file handles:
- Theme switching with localStorage
- Draggable theme button
- IntersectionObserver for scroll animations
- 3D card tilt effect on hover
- Tap/click feedback

### GSAP Hooks (Optional)

If you load GSAP, use these hooks:

```javascript
// Animate hero section
wmGSAPHooks.animateHero(document.querySelector('.wm-series-hero'));

// Stagger grid items
wmGSAPHooks.animateStagger(document.querySelectorAll('.wm-series-card'));
```

---

## Customization

### Footer Text

1. Go to **Appearance → Customize**
2. Find **Footer Settings**
3. Edit the footer text
4. Click **Publish**

### Colors

Edit CSS variables in `style.css` under `:root`:

```css
:root {
    --wm-primary: #e50914;      /* Main accent color */
    --wm-background: #0a0a0a;   /* Page background */
    --wm-surface: #141414;      /* Card backgrounds */
    --wm-card-glow: rgba(144, 238, 144, 0.15); /* Green glow */
}
```

### Adding Custom Page Templates

1. Create a new PHP file (e.g., `page-custom.php`)
2. Add template header:

```php
<?php
/**
 * Template Name: My Custom Page
 */
get_header();
// Your content here
get_footer();
```

---

## Troubleshooting

### Series not showing?
- Make sure you've added series via **Admin → Series**
- Check that series have "Published" status
- Flush permalinks: **Settings → Permalinks → Save**

### Theme switcher not working?
- Check browser console for JavaScript errors
- Ensure `animations.js` is loading (view page source)
- Clear browser cache/localStorage

### Pages not created?
- Deactivate and reactivate the theme
- Or manually create pages and assign templates

### Episodes not saving?
- Make sure to click **Update** after adding episodes
- Check that download links are valid URLs

---

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Modern browser (Chrome, Firefox, Safari, Edge)

---

## Credits

- Theme by Wave-Movies Team
- Icons: Inline SVG (no external dependencies)
- Fonts: Inter, Bebas Neue (Google Fonts)

---

## License

GNU General Public License v2 or later
