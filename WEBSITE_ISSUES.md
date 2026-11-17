# Website Issues Review

Static review of the current site source. These are findings to resolve or confirm; no page content was changed for this review.

## Issues

1. **Service numbers no longer match the merged service list — Medium**  
   The Solutions page now numbers the combined Import & Export service as 02 and Carrier Coordination as 03, but the detail pages still show the old sequence. For example, Carrier Coordination shows 04 in [service-carrier-coordination.html](pages/service-carrier-coordination.html#L34), while the Solutions card shows 03 in [solutions.html](pages/solutions.html#L97). The later pages are also one number ahead, and Bonded Warehousing still shows 08 although it is 07 in the list. Align the detail page labels with the current Solutions order.

2. **Resolved: Shipment Tracking service removed**  
   The standalone page, sitemap entry, and related service copy have been removed.

3. **Resolved: Personal Gmail removed from public contact details**  
   The contact pages now direct visitors to the company email address. The contact form default recipient also uses the company inbox.

## Checks that passed

- No broken local HTML, CSS, JavaScript, or image links were found in the static audit.
- All reviewed images have alt attributes.
- The homepage and each indexed content page have one H1, a description, and a canonical URL.
