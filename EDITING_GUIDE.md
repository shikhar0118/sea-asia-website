# Simple website editing guide

You do not need to know HTML class names or IDs to request an edit. Describe what you want in everyday language, for example: “Make the homepage headline larger” or “Move the slideshow text higher on mobile.” I can find the right place in the project.

## Where common changes live

| What you want to change | Project file or folder |
| --- | --- |
| Homepage wording and sections | `index.html` |
| Other page wording | Files in `pages/` |
| Contact page layout and enquiry form | `contact.html` |
| Enquiry validation and database saving | `php/contact-submit.php` |
| Colors, fonts, spacing, layout, and mobile appearance | `assets/css/style.css` |
| Slideshow timing and which text goes with each image | `assets/js/main.js` |
| Website photos and logos | `assets/images/` |

The code is grouped with comments by page area and feature. In the stylesheet, start with the section named for the part you want to change. The slideshow scenes are listed together in `assets/js/main.js` and follow the image order in `index.html`.

## Homepage slideshow

- The four slide images are in `assets/images/` and are named `hero-truck.png`, `hero-air.jpg`, `hero-rail.jpg`, and `hero-ship.jpg`.
- The matching slide headlines and descriptions are in `assets/js/main.js`.
- The starting headline is also in `index.html` so it appears immediately when the page opens.

## How to ask for a change

Tell me:

1. Which page or area you mean, such as the homepage, header, slideshow, or footer.
2. What you want it to look or say.
3. If useful, attach a screenshot and point to the part you mean.

You can leave all code names and technical details to me.
