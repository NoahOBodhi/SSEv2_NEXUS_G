# Assets Directory

This directory will house all static assets for the SSEv2 NEXUS G landing page.

## Structure

```
assets/
├── images/       # Graphics, logos, icons, photos
├── css/          # Additional stylesheets (if needed)
└── js/           # Additional JavaScript modules (if needed)
```

## Guidelines

### Images
- Use optimized formats (WebP with fallbacks, or optimized PNG/JPG)
- Include alt text in HTML for accessibility
- Follow naming convention: `descriptive-name-purpose.ext`
- Examples: `crew-badge-icon.svg`, `earth-hero-bg.webp`

### CSS
- Currently all CSS is inline in `index.html` for simplicity
- If/when we extract: use modular, commented stylesheets
- Maintain CSS custom properties (variables) consistency

### JS
- Currently all JS is inline in `index.html` for simplicity
- If/when we extract: use vanilla JS or minimal dependencies
- Keep modules focused and well-documented

## Future Additions

As SSEv2 NEXUS G grows, this directory may include:
- Crew role assessment graphics
- Interactive component assets
- Mission showcase images
- Animation resources
- Icon sets
- Custom fonts (if needed beyond Google Fonts)

## Optimization

All assets should be:
- Compressed/optimized for web
- Appropriately sized for usage
- Accessible (proper formats, descriptions)
- Performant (lazy loading where appropriate)

---

*Currently this directory structure is prepared but not yet populated.*  
*Assets will be added as features develop beyond the simple landing page.*