# Cyberpunk Movie/Series Download Website - Complete WordPress Theme Prompt

## 🎯 Project Overview

Create a **cyberpunk-themed WordPress theme** for a movie and series download website with neon pink and electric blue aesthetics. The theme should have a dark, futuristic feel with glowing effects, gradients, and modern animations.

---

## 🎨 Design Theme: Cyberpunk Neon

### Color Palette
- **Primary**: Neon Pink (#FF2D95 / #FF0080)
- **Secondary**: Electric Blue (#00D4FF / #0099FF)
- **Accent**: Neon Purple (#9D00FF)
- **Background**: Deep Dark (#0A0A0F / #121218)
- **Surface**: Dark Gray (#1A1A24 / #252532)
- **Text**: White (#FFFFFF) and Light Gray (#B0B0C0)
- **Glow Effects**: Use box-shadow with neon colors for glowing borders and buttons

### Visual Style
- Dark backgrounds with neon accents
- Glowing borders and hover effects
- Gradient overlays (pink to blue)
- Futuristic fonts (Orbitron, Rajdhani, or similar)
- Subtle grid/circuit patterns in backgrounds
- Smooth animations and transitions
- Card designs with glass-morphism effect

---

## 📐 Layout Structure

### Header
```
┌─────────────────────────────────────────────────────────────┐
│                      [WEBSITE NAME/LOGO]                     │
│                    (Glowing neon text style)                 │
├─────────────────────────────────────────────────────────────┤
│              🔍 [        Search Bar         ] [Search]       │
├─────────────────────────────────────────────────────────────┤
│  [Movies] | [Series] | [Anime] | [K-Drama] | [Hollywood]    │
│           (Horizontal navigation with neon hover effects)    │
└─────────────────────────────────────────────────────────────┘
```

### Content Area
- Grid layout for movie/series cards
- Cards with poster image, title, year, rating
- Hover effects with neon glow
- Lazy loading for images

### Footer (Admin Customizable)
```
┌─────────────────────────────────────────────────────────────┐
│  [Logo]              [About Text]           [Trailer Link]   │
├─────────────────────────────────────────────────────────────┤
│  Social Icons: [Facebook] [Twitter] [Instagram] [Telegram]   │
│                [YouTube] [TikTok] [Discord]                  │
├─────────────────────────────────────────────────────────────┤
│              © 2024 [Site Name]. All rights reserved.        │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔧 WordPress Admin Features

### 1. Theme Options Panel (Footer Settings)
Create a dedicated settings page under **Appearance → Theme Options** or use the Customizer:

```php
// Footer Options to include:
- Site Logo Upload
- About Text (Textarea)
- Featured Trailer URL (Movie/Series trailer embed link)
- Copyright Text

// Social Media Links (Pre-built icons, admin just adds URLs):
- Facebook URL
- Twitter/X URL
- Instagram URL
- Telegram URL
- YouTube URL
- TikTok URL
- Discord URL
- WhatsApp URL
```

### 2. Custom Post Types (Auto-created on theme activation)

#### Movies CPT
```
Post Type: movie
- Title
- Description (Content)
- Featured Image (Poster)
- Meta Fields:
  - Release Year
  - Rating (e.g., 7.5/10)
  - Duration (e.g., 2h 15m)
  - Quality Options (Array of download links):
    [
      { quality: "480p", size: "400MB", link: "url" },
      { quality: "720p", size: "800MB", link: "url" },
      { quality: "1080p", size: "1.5GB", link: "url" },
      { quality: "4K", size: "4GB", link: "url" }
    ]
  - Screenshots (Gallery)
  - Trailer URL
  - IMDB Link
```

#### Series CPT
```
Post Type: series
- Title
- Description (Content)
- Featured Image (Poster)
- Meta Fields:
  - Release Year
  - Rating
  - Status (Ongoing/Completed)
  - Total Episodes (Manual input for display)
  - Download Groups (Multiple quality versions):
    [
      {
        name: "720p HEVC",
        episodes: [
          { number: 1, title: "Episode Title", link: "url" },
          { number: 2, title: "Episode Title", link: "url" },
          ...
        ],
        season_zip: "url"
      },
      {
        name: "1080p x264",
        episodes: [...],
        season_zip: "url"
      }
    ]
  - Screenshots (Gallery)
  - Trailer URL
```

### 3. Taxonomies
```
- Genre (shared): Action, Comedy, Drama, Horror, Sci-Fi, Romance, Thriller, etc.
- Category: Movies, Series, Anime, K-Drama, Hollywood, Bollywood, etc.
- Year: 2024, 2023, 2022, etc.
- Quality: 480p, 720p, 1080p, 4K, etc.
```

---

## 📄 Page Templates

### 1. Homepage (index.php / front-page.php)
- Hero section with featured content slider
- Latest Movies section (grid)
- Latest Series section (grid)
- Trending/Popular section
- Category showcase

### 2. Archive Pages
- **Movies Archive** (/movies/)
- **Series Archive** (/series/)
- **Anime Archive** (/category/anime/)
- **K-Drama Archive** (/category/k-drama/)
- Filterable grid with pagination
- Sort by: Latest, Popular, Rating, Year

### 3. Single Movie Page (single-movie.php)
```
┌─────────────────────────────────────────────────────────────┐
│ Breadcrumbs: Home > Movies > [Movie Title]                  │
├─────────────────────────────────────────────────────────────┤
│ ┌──────────┐                                                │
│ │  POSTER  │  [Movie Title]                                 │
│ │          │  Year: 2024 | Rating: 8.5 | Duration: 2h 15m   │
│ │          │                                                │
│ │          │  [Description/Synopsis]                        │
│ └──────────┘                                                │
├─────────────────────────────────────────────────────────────┤
│                    DOWNLOAD OPTIONS                          │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐            │
│  │ 480p        │ │ 720p        │ │ 1080p       │            │
│  │ 400MB       │ │ 800MB       │ │ 1.5GB       │            │
│  │ [DOWNLOAD]  │ │ [DOWNLOAD]  │ │ [DOWNLOAD]  │            │
│  └─────────────┘ └─────────────┘ └─────────────┘            │
├─────────────────────────────────────────────────────────────┤
│                    SCREENSHOTS                               │
│  [img1] [img2] [img3] [img4]                                │
├─────────────────────────────────────────────────────────────┤
│                    TRAILER                                   │
│  [Embedded YouTube/Video Player]                            │
└─────────────────────────────────────────────────────────────┘
```

### 4. Single Series Page (single-series.php)
```
┌─────────────────────────────────────────────────────────────┐
│ Breadcrumbs: Home > Series > [Series Title]                 │
├─────────────────────────────────────────────────────────────┤
│ ┌──────────┐                                                │
│ │  POSTER  │  [Series Title]                                │
│ │          │  Year: 2024 | Rating: 9.0 | Status: Ongoing    │
│ │          │  Episodes: 12                                  │
│ │          │                                                │
│ │          │  [Description/Synopsis]                        │
│ └──────────┘                                                │
├─────────────────────────────────────────────────────────────┤
│                    SCREENSHOTS                               │
│  [img1] [img2] [img3] [img4]                                │
├─────────────────────────────────────────────────────────────┤
│               SELECT DOWNLOAD QUALITY                        │
│  ┌─────────────────┐ ┌─────────────────┐                    │
│  │ 720p HEVC       │ │ 1080p x264      │                    │
│  │ 10 Episodes     │ │ 10 Episodes     │                    │
│  │ [VIEW EPISODES] │ │ [VIEW EPISODES] │                    │
│  └─────────────────┘ └─────────────────┘                    │
└─────────────────────────────────────────────────────────────┘
```

### 5. Episodes List Page (Separate page per quality group)
```
URL: /series/[series-name]/?group=0

┌─────────────────────────────────────────────────────────────┐
│ [Series Title] - 720p HEVC Episodes                         │
│ Total Episodes: 10                                          │
├─────────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────────────────────┐ │
│ │ Episode 01 - Pilot                        [DOWNLOAD] ↓  │ │
│ ├─────────────────────────────────────────────────────────┤ │
│ │ Episode 02 - The Beginning                [DOWNLOAD] ↓  │ │
│ ├─────────────────────────────────────────────────────────┤ │
│ │ Episode 03 - Rising Tension               [DOWNLOAD] ↓  │ │
│ ├─────────────────────────────────────────────────────────┤ │
│ │ ...                                                      │ │
│ └─────────────────────────────────────────────────────────┘ │
├─────────────────────────────────────────────────────────────┤
│              [📦 DOWNLOAD SEASON ZIP - 2.5GB]               │
├─────────────────────────────────────────────────────────────┤
│ Other Qualities: [720p HEVC] [1080p x264]                   │
│                                                             │
│              [← BACK TO SERIES]                             │
└─────────────────────────────────────────────────────────────┘
```

### 6. Download Page (Countdown + Redirect)
```
URL: /download/?link=[encoded-url]

┌─────────────────────────────────────────────────────────────┐
│                                                             │
│                    ⬇️ DOWNLOAD                              │
│                                                             │
│            Your download will start in: [5]                 │
│                                                             │
│    If download doesn't start automatically,                 │
│              [CLICK HERE TO DOWNLOAD]                       │
│                                                             │
│                   [← BACK TO HOME]                          │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### 7. Search Results Page
- Grid layout matching archive pages
- Shows both movies and series
- Filters for type, genre, year

### 8. About Page
- Static content page
- Uses footer "About" text or separate content

---

## 🔌 Required Functionality

### On Theme Activation
```php
// Auto-create pages:
- Home (set as front page)
- Search
- Download
- About

// Auto-register:
- Movies CPT
- Series CPT
- Genre Taxonomy
- Category Taxonomy

// Create default menu locations:
- Primary Navigation (Categories)
- Footer Navigation
```

### Download Flow
1. User clicks download button on movie/series page
2. Link goes to `/download/?link=[base64-encoded-url]`
3. Download page shows 5-second countdown
4. Auto-redirects to actual download link
5. Manual download link provided as fallback

### View Counter
- Track views for movies and series
- Display view count on cards and single pages

---

## 🎭 Animation & Effects

### CSS Animations
- Neon glow pulse on buttons
- Card hover lift with glow
- Smooth page transitions
- Loading skeleton animations
- Gradient text animations for titles

### Hover Effects
- Cards: Scale up + neon border glow
- Buttons: Glow intensify + color shift
- Navigation: Underline slide + glow
- Images: Brightness increase + overlay

---

## 📱 Responsive Design

### Breakpoints
- Desktop: 1200px+
- Tablet: 768px - 1199px
- Mobile: 320px - 767px

### Mobile Considerations
- Hamburger menu for navigation
- Full-width cards on mobile
- Touch-friendly download buttons
- Collapsible episode lists
- Swipeable screenshot gallery

---

## 🔍 SEO Features

### Auto-Generated
- Dynamic meta titles and descriptions
- Open Graph tags for social sharing
- Twitter Cards
- JSON-LD Schema (Movie, TVSeries, WebSite, BreadcrumbList)
- XML Sitemap support
- Canonical URLs
- Breadcrumb navigation

### Admin Options
- Custom meta description per post
- Focus keyword field
- robots.txt configuration

---

## 📁 Theme File Structure

```
theme-name/
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── front-page.php
├── single-movie.php
├── single-series.php
├── archive-movie.php
├── archive-series.php
├── page-search.php
├── page-download.php
├── page-about.php
├── search.php
├── 404.php
├── sidebar.php
├── template-parts/
│   ├── movie-card.php
│   ├── series-card.php
│   ├── episodes-list.php
│   └── download-buttons.php
├── inc/
│   ├── theme-options.php
│   ├── custom-post-types.php
│   ├── meta-boxes.php
│   ├── seo-functions.php
│   └── helper-functions.php
├── assets/
│   ├── css/
│   │   └── main.css
│   ├── js/
│   │   ├── main.js
│   │   └── admin.js
│   └── images/
│       └── placeholder.jpg
└── languages/
    └── theme-name.pot
```

---

## ⚡ Performance

- Lazy loading for all images
- Minified CSS/JS
- GZIP compression via .htaccess
- Browser caching headers
- Optimized database queries
- CDN-ready asset URLs

---

## 🛡️ Security

- Sanitize all user inputs
- Escape all outputs
- Nonce verification for forms
- Capability checks for admin functions
- Prepared SQL statements

---

## 📋 Summary Checklist

- [ ] Cyberpunk neon pink/blue theme
- [ ] Dark futuristic design with glow effects
- [ ] Movies CPT with direct download buttons
- [ ] Series CPT with episode list system
- [ ] Multiple quality/download groups
- [ ] Season ZIP download option
- [ ] Countdown download page
- [ ] Admin footer options panel
- [ ] Pre-built social media icons (admin adds links)
- [ ] About text in footer options
- [ ] Trailer link option in footer
- [ ] Category navigation (Movies, Series, Anime, K-Drama, etc.)
- [ ] Search functionality
- [ ] Responsive design
- [ ] SEO optimized
- [ ] Fast and performant

---

## 🚀 Usage

Copy this prompt and provide it to an AI assistant or developer to generate the complete WordPress theme code with all features described above.
